<?php 

namespace app\controllers;

use core\Controller;
use app\controllers\Users;

class Home extends Controller {

    function __construct() {
        $this->user_dao = $this->dao('User');
        $this->calendar_dao = $this->dao('Calendar');
        $this->event_dao = $this->dao('Event');
    }

    public function index() {
        if (isset($_SESSION['tptickets_is_admin'])) {
            $this->view('admin/admin');
        } else {
            $data['events'] = $this->event_dao->retrieveAll();
            if (empty($data['events'])) {
                $data['err'] = "NO HAY EVENTOS DISPONIBLES";
            }
            $this->view('home/index', $data);
        }
    }

    //busca por nombre artista, nombre evento, lugar
    public function search($string) {

        $data['events'] = $this->event_dao->retrieveByString($string);

        if($data['events'] != null) { 
            $this->view('home/search', $data);
        } else {
            $data['err'] = "No hay resultados.";
            $this->view('', $data);
        }
    }

    public function showEvent($id_event) {
        
        $data['calendars'] = array();//  la vista search esta codeada para que reciba un array
        $calendar = $this->calendar_dao->retrieveByEventId($id_event);
        array_push($data['calendars'], $calendar);
        if($data['calendars'] != null) {
            $this->view('home/show_event', $data);
        } else {
            $this->index();
        }
    }
}
