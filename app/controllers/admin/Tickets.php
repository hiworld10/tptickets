<?php

namespace app\controllers\admin;

use core\View;

class Tickets extends \app\controllers\Authentication
{    
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->ticket_dao = $this->dao('Ticket');
    }
    /**
     * Lista los tickets efectuados en sistema.
     * @return void
     */
    public function index()
    {
        $data['tickets'] = $this->ticket_dao->retrieveAll();
        View::render('admin/tickets', $data);
    }
}
