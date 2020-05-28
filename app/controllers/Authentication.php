<?php 

namespace app\controllers;

use app\Auth;

abstract class Authentication extends \core\Controller
{   
    protected function requireUserLogin()
    {
        if (!Auth::isUserLoggedIn()) {
            $this->redirect('users/login');
        }
    }

    protected function requireAdminLogin()
    {
        if (!Auth::isAdminLoggedIn()) {
            $this->redirect('users/login');
        }
    }
}

 ?>