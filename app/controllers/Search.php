<?php 

namespace app\controllers;

use core\View;

class Search extends \core\Controller
{
    public function __construct()
    {
        $this->event_dao = $this->dao('Event');
        $this->artist_dao = $this->dao('Artist');  
        $this->category_dao = $this->dao('Category');  
    }

    public function index($string)
    {
        $data['events'] = $this->event_dao->retrieveActiveEventsByString($string);
        View::render('search/index', $data);
    }

    public function advanced()
    {
        $data['artists'] = $this->artist_dao->retrieveAll();
        $data['categories'] = $this->category_dao->retrieveAll();
        View::render('search/advanced', $data);
    }
}