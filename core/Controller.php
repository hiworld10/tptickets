<?php 

namespace core;

/**
 * Controladora base de la cual otras extenderán. Provee las funcionalidades básicas de carga de objetos con acceso a modelos (DAO) y vistas.
 */

Class Controller {

    public function dao($dao) {
        $dao = $dao . 'DAO';
        $namespace = 'app\dao\db\\';
        $file = '../app/dao/db/' . $dao . '.php';
        if (file_exists($file)) {
            $class = $namespace . $dao;
            return new $class;
        }
    }

    public function view($view, $data = []) {
        if (empty($view)) {
            $view = 'home/index';
        }
        $file = '../app/views/' . $view . '.php';
        if(file_exists($file)) {
            require_once $file;
        } else {
            die('Error: la vista no pudo encontrarse en la ruta ' . $file);
        }
    }
}

?> 
