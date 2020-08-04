<?php

/**
 * Inicialización de autoloader y configuración
 */
require "../app/autoload/autoload.php";
require "../app/config/config.php";

/**
 * Autoloader para incluir las dependencias instaladas mediante composer
 */
require "../vendor/autoload.php";

/**
 * Archivo con las credenciales necesarias para el funcionamiento del programa.
 * Ver 'app/config/credentials_template.php' para más detalles.
 */
require "../../credentials.php";

/**
 * Incluir funciones utilitarias de manera global
 */
require "../app/utils/helper_functions.php";

/**
 * Mostrar errores de PHP
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Añadir handler para errores y excepciones
 */
set_error_handler('core\Error::errorHandler');
set_exception_handler('core\Error::exceptionHandler');

/**
 * Usos
 */
use core\Request;
use core\Router;

/**
 * Inicio de $_SESSION
 */
if (!isset($_SESSION)) {
    session_start();
}
/**
 * Flujo de ejecución
 */
new Router(new Request);

