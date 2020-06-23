<?php

namespace app\controllers;

use app\Auth;
use app\utils\Flash;

class Purchases extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireUserLogin();

        $this->event_seat_dao    = $this->dao('EventSeat');
        $this->purchase_dao      = $this->dao('Purchase');
        $this->purchase_line_dao = $this->dao('PurchaseLine');
        $this->ticket_dao        = $this->dao('Ticket');
    }

    public function addNewLine()
    {
        $this->redirectIfRequestIsNotPost('');

        if ($this->purchase_dao->addNewLineInSession($_POST)) {
            Flash::addMessage('El item fue añadido a tu carro de compra exitosamente.');
            $this->redirect('/');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);
            $this->redirect('/');
        }
    }

    public function removeLine($id_event_seat)
    {
        $this->redirectIfRequestIsNotPost('');

        if ($this->purchase_dao->removeLineInSession($id_event_seat)) {
            Flash::addMessage('El item fue eliminado de tu carro exitosamente.');
            $this->redirect('/purchases/show-cart');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);
            $this->redirect('/purchases/show-cart');
        }
    }

    public function confirm()
    {
        $data = $this->purchase_dao->getAllLinesInSession();
        $this->view('purchases/confirm', $data);
    }

    public function checkout()
    {
        $this->redirectIfRequestIsNotPost('');

        // Si este atributo (provenido de la confirmación de compra) no está seteado, se redirecciona al inicio
        if (!isset($_POST['tptickets_purchase_confirmed'])) {
            redirect('/');
        }

        // Comprobar si el usuario es válido y está en sesión
        $user = Auth::getUser();

        // Redireccionar al inicio si no es así
        if (!$user) {
            $this->redirect('/');
        }

        // SE DEBE COMPROBAR DE ANTEMANO SI ALGUNA DE LAS PLAZAS INCLUIDAS EN EL CARRO DE
        // COMPRA SE AGOTÓ PREVIO A LAS SIGUIENTES INSTRUCCIONES Y, SI ES ASÍ, ESTE
        // PROCEDIMIENTO DEBE CANCELARSE POR COMPLETO

        echo '<pre>';
        print_r($_SESSION['tptickets_items']);
        echo '</pre>';

        $purchase_data = ['id_client' => $user->getId()];

        // Si se pasan las validaciones, se crea un nuevo registro de compra en la BD
        $this->purchase_dao->create($purchase_data);

        // Se obtiene el ID de compra recientemente creado
        $id_purchase = $this->purchase_dao->retrieveLastId();

        // Se recorre la lista de lineas de compra en sesión y se crean los registros correspondientes
        foreach ($_SESSION['tptickets_items'] as $item) {
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
            $ticket_data = [
                'id_purchase_line' => $id_purchase_line,
                'number'           => $item['amount'],
                // Aún resta implementar la creación de qr
                'qr'               => null,
            ];
            // Creación de registro de ticket
            $this->ticket_dao->create($ticket_data);
        }

        // Resetear el carro de compra
        unset($_SESSION['tptickets_items']);
        unset($_SESSION['tptickets_subtotal']);

        echo '<pre>';
        print_r($this->purchase_dao->retrieveAll());
        echo '</pre>';

        echo '<pre>';
        print_r($this->purchase_line_dao->retrieveAll());
        echo '</pre>';

        echo '<pre>';
        print_r($this->ticket_dao->retrieveAll());
        echo '</pre>';
    }

    public function emptyCart()
    {
        $this->redirectIfRequestIsNotPost('');

        if ($this->purchase_dao->removeAllLinesInSession()) {
            Flash::addMessage('Todos los items en tu carro han sido eliminados exitosamente.');
            $this->redirect('/purchases/show-cart');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);
            $this->redirect('/purchases/show-cart');
        }
    }

    public function showCart()
    {
        //obtiene $data['items'] y $data['subtotal']
        $data = $this->purchase_dao->getAllLinesInSession();
        $this->view('purchases/show_cart', $data);
    }
}
