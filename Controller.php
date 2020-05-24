<?php 

namespace core;

abstract class Controller {

    private $model;

    public function model($model) {
        $this->model = $model;
    }

    public function view($page, $data = []) {
        $file = '../app/views/' . $page;// . '.php';
        if (is_readable($file)) {
            require $file;
        } else {
            die("Error: Requested view file not found");
        }
    }

    public function viewTwigTemplate($page, $data = []) {

        $twig = null;

        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader('../app/views');
            $twig = new \Twig\Environment($loader);
        }
        echo $twig->render($page, $data);
    }    
}

 ?>