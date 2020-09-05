<?php

namespace app\controllers\admin;

use core\View;

class PurchaseLines extends \app\controllers\Authentication
{    
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->purchase_line_dao = $this->dao('PurchaseLine');
    }
    /**
     * Lista las líneas de compra en sistema.
     * @return void
     */
    public function index()
    {
        $data['purchase_lines'] = $this->purchase_line_dao->retrieveAll();
        View::render('admin/purchase_lines', $data);
    }
}
