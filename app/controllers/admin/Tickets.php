<?php

namespace app\controllers\admin;

class Tickets extends \app\controllers\Authentication
{    
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->ticket_dao = $this->dao('Ticket');
    }

    public function index()
    {
        $data['tickets'] = $this->ticket_dao->retrieveAll();
        $this->view('admin/tickets', $data);
    }
}
