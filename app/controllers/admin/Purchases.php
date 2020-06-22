<?php

namespace app\controllers\admin;

class Purchases extends \app\controllers\Authentication
{    
    public function __construct()
    {
        $this->purchase_dao = $this->dao('Purchase');
    }

    public function index()
    {
        $data['purchases'] = $this->purchase_dao->retrieveAll();
        $this->view('admin/purchases', $data);
    }
}
