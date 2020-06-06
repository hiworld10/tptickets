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
            $data['events'] = $this->event_dao->retrieveAllActive();
            $this->view('home/index', $data);
        }
    }

    //busca por nombre artista, nombre evento, lugar
    public function search($string) {

        $data['events'] = $this->event_dao->retrieveActiveEventsByString($string);

        $this->view('home/search', $data);
    }

    public function showEvent($id_event) {
        
        $data['calendars'] = $this->calendar_dao->retrieveByEventId($id_event);
        if(isset($data['calendars'])) {
            $this->view('home/show_event', $data);
        } else {
            $this->index();
        }
    }
}
