<?php

/* Directorios principales */
define('PROJECT_ROOT', dirname(dirname(__DIR__)));
define('APP_ROOT', dirname(__DIR__));
define('PUBLIC_ROOT', PROJECT_ROOT . '/public');
define('VIEWS_ROOT', APP_ROOT . '/views/');
define('ADMIN_VIEWS', APP_ROOT . '/views/admin');
define('IMG_UPLOADS', PUBLIC_ROOT . '/img');

/* Vistas principales */
define('HEADER', VIEWS_ROOT . 'inc/header.php');
define('NAVBAR', VIEWS_ROOT . 'inc/navbar.php');
define('ADMIN_NAVBAR', VIEWS_ROOT . 'inc/admin_navbar.php');
define('FOOTER', VIEWS_ROOT . 'inc/footer.php');
define('FLASH_MESSAGES', VIEWS_ROOT . 'inc/flash_messages.php');

/* Rutas URL */
define('FRONT_ROOT', 'http://localhost/tptickets');
define('ADMIN_FRONT_ROOT', FRONT_ROOT . '/views/admin');
define('IMG_FRONT_ROOT', FRONT_ROOT . '/img');
define('CSS_PATH', FRONT_ROOT . '/content/css');

/* Media */
define('IMG_UPLOADS_PATH', FRONT_ROOT . '/content/uploads/img');
define('MOV_UPLOADS_PATH', FRONT_ROOT . '/content/uploads/movies');

/* Credenciales de BD */
define('DB_HOST', 'localhost');
define('DB_NAME', 'tptickets');
define('DB_USER', 'root');
define('DB_PASS', '');

?>
