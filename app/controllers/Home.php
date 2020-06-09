<?php

namespace app\controllers;

use core\Controller;

class Home extends Controller
{

    public function __construct()
    {
        $this->event_dao = $this->dao('Event');
    }

    public function index()
    {
        if (isset($_SESSION['tptickets_is_admin'])) {
            $this->view('admin/admin');
        } else {
            $data['events'] = $this->event_dao->retrieveAllActive();
            $this->view('home/index', $data);
        }
    }

    //busca por nombre artista, nombre evento, lugar
    public function search($string)
    {
        $data['events'] = $this->event_dao->retrieveActiveEventsByString($string);
        $this->view('home/search', $data);
    }
}
