<?php

  /**
   * Mostrar errores de PHP
   */
  //ini_set('memory_limit', '4096M');
  
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  

  /**
   * Archivos necesarios de inicio
   */
  require "../app/autoload/autoload.php";
  require "../app/config/data.php";

  /**
   * Alias
   */
  use app\autoload\Autoload;
  use config\Router;
  use config\Request;

  /**
   * Flujo de ejecución
   */

  Autoload::start();

  $request = new Request();

  Router::direct($request);
