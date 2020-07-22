<?php

namespace app\controllers\admin;

use core\View;

class Purchases extends \app\controllers\Authentication
{    
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->purchase_dao = $this->dao('Purchase');
    }

    public function index()
    {
        $data['purchases'] = $this->purchase_dao->retrieveAll();
        View::render('admin/purchases', $data);
    }
}
