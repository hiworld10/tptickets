<?php

namespace app\controllers;

class Purchases extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->purchases_dao = $this->dao('Purchases');
    }        
}