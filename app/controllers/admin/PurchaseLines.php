<?php

namespace app\controllers\admin;

class PurchaseLines extends \app\controllers\Authentication
{    
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->purchase_line_dao = $this->dao('PurchaseLine');
    }

    public function index()
    {
        $data['purchase_lines'] = $this->purchase_line_dao->retrieveAll();
        $this->view('admin/purchase_lines', $data);
    }
}
