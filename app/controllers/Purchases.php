<?php

namespace app\controllers;

use app\Auth;
use app\Mail;
use app\utils\Flash;
use core\View;

class Purchases extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireUserLogin();

        $this->calendar_dao      = $this->dao('Calendar');
        $this->event_seat_dao    = $this->dao('EventSeat');
        $this->purchase_dao      = $this->dao('Purchase');
        $this->purchase_line_dao = $this->dao('PurchaseLine');
        $this->ticket_dao        = $this->dao('Ticket');
    }

    /**
     * Agrega una nuevo ítem al carro en sesión.
     */
    public function addNewLine()
    {
        $this->redirectIfRequestIsNotPost('/');

        if ($this->purchase_dao->addNewLineInSession($_POST)) {
            Flash::addMessage('El item fue añadido a tu carro de compra exitosamente.');
            $this->redirect('/');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);
            $this->redirect('/');
        }
    }

    /**
     * Remueve un ítem del carro en sesión.
     * @param  $id_event_seat El ID del asiento del evento
     * @return void
     */
    public function removeLine($id_event_seat)
    {
        $this->redirectIfRequestIsNotPost('/');

        if ($this->purchase_dao->removeLineInSession($id_event_seat)) {
            Flash::addMessage('El item fue eliminado de tu carro exitosamente.');
            $this->redirect('/purchases/show-cart');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);
            $this->redirect('/purchases/show-cart');
        }
    }

    /**
     * Muestra la información de los ítems y pregunta por confirmación de la compra.
     * @return void
     */
    public function confirm()
    {
        $data = $this->purchase_dao->prepareCheckoutDetails();
        View::render('purchases/confirm', $data);
    }

    /**
     * Ejecuta la compra, modificando apropiadamente la información ya existente en la 
     * base de datos, y generando nuevos registros de compra, líneas de compra y tickets.
     * @return void
     */
    public function checkout()
    {
        $this->redirectIfRequestIsNotPost('/');

        // Si este atributo (provenido de la confirmación de compra) no está seteado, se redirecciona al inicio
        if (!isset($_POST['tptickets_purchase_confirmed'])) {
            $this->redirect('/');
        }

        // Comprobar si el usuario es válido y está en sesión
        $user = Auth::getUser();

        // Redireccionar al inicio si no es así
        if (!$user) {
            $this->redirect('/');
        }

        $items = $_SESSION['tptickets_items'];
        $purchase_total = $_SESSION['tptickets_total'];

        // Comprobar si alguno de los eventos seleccionados ya no tiene asientos disponibles
        $available_seats = true;

        foreach ($items as $key => $item) {
            $event_seat = $this->event_seat_dao->retrieveById($item['id_event_seat']);

            if (!$event_seat->hasAvailable($item['amount'])) {
                $_SESSION['tptickets_subtotal'] -= $item['subtotal'];
                // Sacarlo de la lista de ítems del carro de compra si es así
                unset($_SESSION['tptickets_items'][$key]);
                $available_seats = false;
            }
        }

        // Redireccionar avisando al usuario de lo ocurrido
        if (!$available_seats) {
            Flash::addMessage('No se ha podido efectuar la compra debido a que ciertos ítems en tu carro de compra ya no están disponibles. Esto puede deberse a que el tipo de asiento del evento se agotó momentos antes de la confirmación de tu compra. Dichos ítems se han quitado de la lista.', Flash::WARNING);
            $this->redirect('/purchases/show-cart');
        }

        // Caso contrario, continuar
        $purchase_data = [
            'id_user' => $user->getId(),
            'total'     => $purchase_total
        ];

        // Si se pasan las validaciones, se crea un nuevo registro de compra en la BD
        $this->purchase_dao->create($purchase_data);

        // Se obtiene el ID de compra recientemente creado
        $last_purchase = $this->purchase_dao->retrieveById(
            $this->purchase_dao->retrieveLastId()
        );
        $id_purchase = $last_purchase->getId();
        $purchase_date = $last_purchase->getDate();

        $qr_list = [];
        $ticket_id_list = [];

        // Se recorre la lista de lineas de compra en sesión y se crean los registros correspondientes
        foreach ($items as $item) {
            // Se actualiza el remanente de la plaza de evento
            $this->event_seat_dao->updateRemainder($item['id_event_seat'], $item['amount']);

            // Preparación de datos para el registro de línea de compra
            $purchase_line_data = [
                'id_event_seat' => $item['id_event_seat'],
                'id_purchase'   => $id_purchase,
                'quantity'      => $item['amount'],
                'price'         => $item['subtotal'],
            ];

            // Creación de registro de línea de compra
            $this->purchase_line_dao->create($purchase_line_data);

            // Se obtiene el ID de línea de compra
            $id_purchase_line = $this->purchase_line_dao->retrieveLastId();

            // Preparación de datos para el registro de ticket
            
            $qr_content = "TPTickets\nEvento: " . 
                            $item['event']->getName() . 
                            "\nFecha: " . 
                            $item['date'] .
                            "\nTipo asiento: " .
                            $item['seat_type'] . 
                            "\nCantidad: " . 
                            $item['amount'] . 
                            "\nID ticket: ";        //Este último se almacena posteriormente

            $ticket_data = [
                'id_purchase_line' => $id_purchase_line,
                'number'           => $item['amount'],
                'qr'               => $qr_content,
            ];
            // Creación de registro de ticket
            $this->ticket_dao->create($ticket_data);

            $last_ticket = $this->ticket_dao->retrieveById($this->ticket_dao->retrieveLastId());

            $qr_list[] = $last_ticket->getQr();
            $ticket_id_list[] = $last_ticket->getId();
        }

        foreach ($qr_list as $key => $qr) {
            $items[$key]['qr'] = $qr;
        }

        foreach ($ticket_id_list as $key => $id) {
            $items[$key]['id_ticket'] = $id;
        }

        $total = $_SESSION['tptickets_total'];
        
        // Preparación de datos para envio de email
        $purchase_data_for_email = [
            'items' => $items,
            'total' => $total,
            'id_purchase' => $id_purchase,
            'purchase_date' => $purchase_date,
            'name' => $user->getName(),
            'bundle_info' => $this->purchase_dao->getBundlesWithDiscounts()
        ];

        // Resetear el carro de compra
        unset($_SESSION['tptickets_items']);
        unset($_SESSION['tptickets_subtotal']);
        unset($_SESSION['tptickets_total']);

        $_SESSION['tptickets_items'] = [];
        $_SESSION['tptickets_subtotal'] = 0;

        (new Mail())->purchaseDetails($user->getEmail(), $purchase_data_for_email);
        
        // $_SESSION['purchase_data'] = $purchase_data_for_email;         
        // Variable en sesión utilizada por success()
        $_SESSION['purchase_success'] = 'true';

        $this->redirect('/purchases/success');
    }

    /**
     * Muestra una pantalla indicando que la compra efectuada ha sido exitosa. Esta sólo 
     * aparece una vez realizada dicha compra.
     * @return void
     */
    public function success()
    {   
        if (isset($_SESSION['purchase_success'])) {
            unset($_SESSION['purchase_success']);

            View::render('/purchases/success');
            exit;
        }

        $this->redirect('/');
    }

    /**
     * Vacía todos los ítems del carro de compra en sesión.
     * @return void
     */
    public function emptyCart()
    {
        $this->redirectIfRequestIsNotPost('/');

        if ($this->purchase_dao->removeAllLinesInSession()) {
            Flash::addMessage('Todos los items en tu carro han sido eliminados exitosamente.');
            $this->redirect('/purchases/show-cart');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);
            $this->redirect('/purchases/show-cart');
        }
    }

    /**
     * Muestra el carro de compra con sus respectivos ítems.
     * @return void
     */
    public function showCart()
    {
        //obtiene $data['items'] y $data['subtotal']
        $data = $this->purchase_dao->prepareCheckoutDetails();
        View::render('purchases/show_cart', $data);
    }

    /**
     * Muestra el historial de compras realizadas por el usuario en sesión.
     * @return void
     */
    public function showHistory()
    {
        $data['purchases'] = $this->purchase_dao->retrieveByUserId(Auth::getUser()->getId());
        View::render('purchases/show_history', $data);
    }

    /**
     * Muestralos detalles de una compra específica del usuario en sesión.
     * @param  $purchase_id El ID de la compra a detallar
     * @return void
     */
    public function showPurchaseDetails($purchase_id)
    {
        $data['purchase'] = $this->purchase_dao->retrieveById($purchase_id);

        // Prevenir que el usuario pueda ver detalles de compra que no le pertenecen.
        if ($data['purchase']->getUserId() != Auth::getUser()->getId()) {
            $this->redirect('/');
        }

        $data['seat_types'] = [];
        $data['event_seat_prices'] = [];
        $data['event_names'] = [];
        $data['dates'] = [];

        foreach ($data['purchase']->getPurchaseLineArr() as $value) {
            $event_seat = $this->event_seat_dao->retrieveById($value->getEventSeatId());
            $calendar = $this->calendar_dao->retrieveById($event_seat->getCalendarId());

            $data['seat_types'][] = $event_seat->getSeatType()->getType();
            $data['event_seat_prices'][] = $event_seat->getPrice();
            $data['event_names'][] = $calendar->getEvent()->getName();
            $data['dates'][] = $calendar->getDate();
        }

        View::render('purchases/show_purchase_details', $data);
    }
}
