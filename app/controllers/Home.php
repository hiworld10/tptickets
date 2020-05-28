<?php 

namespace app\controllers;

use core\Controller;
use app\controllers\Users;

class Home extends Controller {

    function __construct() {
        $this->user_dao = $this->dao('User');
        $this->calendar_dao = $this->dao('Calendar');
    }

    public function index() {
        $data['calendars'] = $this->calendar_dao->retrieveAll();
        $this->view('home/index', $data);
    }

    //busca por nombre artista, nombre evento, lugar
    public function search($string) {
        $data['calendars'] = $this->calendar_dao->retrieveCalendarsByString($string);

        if($data['calendars'] != null) { 
            $this->view('home/search', $data);
        } else {
            $data['err'] = "No hay resultados.";
            $this->view('', $data);
        }
    }

    public function getCalendar($id_calendar) {
        
        $data['calendars'] = array();//  la vista search esta codeada para que reciba un array
        $calendar = $this->calendar_dao->retrieveById($id_calendar);
        array_push($data['calendars'], $calendar);
        if($data['calendars'] != null) {
            $this->view('home/search', $data);
        } else {
            $this->index();
        }
    }
}
