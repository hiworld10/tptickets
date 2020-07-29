<?php 

namespace app\controllers;

use core\View;

class Search extends \core\Controller
{
    public function __construct()
    {
        $this->event_dao = $this->dao('Event');    
    }

    public function index($string)
    {
        $data['events'] = $this->event_dao->retrieveActiveEventsByString($string);
        View::render('home/search', $data);
    }
}