<?php

namespace app\controllers\admin;

use core\View;

class Bundles extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->bundle_dao = $this->dao('bundle');
    }

    public function index()
    {
        $data['bundles'] = $this->bundle_dao->retrieveAll();
        View::render('admin/bundles', $data);
    }
}