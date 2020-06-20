<?php

namespace app\controllers;

use app\utils\Flash;

class Purchases extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireUserLogin();
        $this->purchase_dao = $this->dao('Purchase');
    }

    public function addNewLine()
    {
        $this->redirectIfRequestIsNotPost('');

        if ($this->purchase_dao->addNewLineInSession($_POST)) {
            Flash::addMessage('El item fue añadido a tu carro de compra exitosamente.');
            $this->redirect('');    
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);            
            $this->redirect('');    
        }
        //Contenido de las lineas de compra en sesión
        /*echo '<pre>';
        print_r($_SESSION['tptickets_items']);
        echo '</pre>';*/
    }

    public function removeLine($id_event_seat)
    {
        $this->redirectIfRequestIsNotPost('');
    }

    public function checkout()
    {
        
    }

    public function emptyAllLines()
    {
        if (isset($_SESSION['tptickets_items'])) {
            unset($_SESSION['tptickets_items']);
        }
    }

    public function showCart()
    {
        $data['items'] = $_SESSION['tptickets_items'];
        $data['subtotal'] = $_SESSION['tptickets_subtotal'];

        $this->view('purchases/show_cart', $data);
    }
}