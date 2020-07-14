<?php

namespace app\controllers\admin;

use core\View;

class PlaceEvents extends \app\controllers\Authentication
{
    private $dao;

    public function __construct()
    {
        $this->requireAdminLogin();

        $this->dao = $this->dao('PlaceEvent');
    }

    public function index()
    {
        $data['place_events'] = $this->dao->retrieveAll();
        View::render('admin/place_events', $data);
    }
}
