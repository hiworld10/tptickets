<?php

namespace app\controllers;

use app\Auth;
use core\Controller;
use core\View;

class Home extends Controller
{

    public function __construct()
    {
        $this->event_dao = $this->dao('Event');
    }

    public function index()
    {
        if (Auth::isAdmin()) {
            View::render('admin/admin');
        } else {
            $data['events'] = $this->event_dao->retrieveAllActive();
            View::render('home/index', $data);
        }
    }

    //busca por nombre artista, nombre evento, lugar
    public function search($string)
    {
        $data['events'] = $this->event_dao->retrieveActiveEventsByString($string);
        View::render('home/search', $data);
    }
}
