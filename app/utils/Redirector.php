<?php 

namespace app\utils;

class Redirector {

    public static function redirect($string) {
        header('Location: ' . FRONT_ROOT . '/' . $string, true, 303);
        exit;
    } 
}

 ?>