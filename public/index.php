<?php

/**
* Mostrar errores de PHP
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
* Archivos necesarios de inicio
*/
require "../app/autoload/Autoload.php";
require "../app/config/config.php";
/**
* Alias
*/
use app\autoload\Autoload;
use core\Router;
use core\Request;
/*
Inicio de $_SESSION
 */
if (!isset($_SESSION)) {
    session_start();
}
/**
* Flujo de ejecución
*/
Autoload::start();
new Router(new Request);

?>