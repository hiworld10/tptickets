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

        if ($this->purchase_dao->removeLineInSession($id_event_seat)) {
            Flash::addMessage('El item fue eliminado de tu carro exitosamente.');
            $this->redirect('purchases/show-cart');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);            
            $this->redirect('purchases/show-cart');             
        }
    }

    public function confirm()
    {
        $data = $this->purchase_dao->getAllLinesInSession();
        $this->view('purchases/confirm', $data);
    }

    public function checkout()
    {
        
    }

    public function emptyCart()
    {
        $this->redirectIfRequestIsNotPost('');

        if ($this->purchase_dao->removeAllLinesInSession()) {
            Flash::addMessage('Todos los items en tu carro han sido eliminados exitosamente.');
            $this->redirect('purchases/show-cart');
        } else {
            Flash::addMessage('No hemos podido procesar la operación en este momento. Intentalo más tarde.', Flash::WARNING);            
            $this->redirect('purchases/show-cart');             
        }
    }

    public function showCart()
    {   
        //obtiene $data['items'] y $data['subtotal']
        $data = $this->purchase_dao->getAllLinesInSession();
        $this->view('purchases/show_cart', $data);
    }
}