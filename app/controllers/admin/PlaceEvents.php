<?php

namespace app\controllers\admin;

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
        $this->view('admin/place_events', $data);
    }
}
