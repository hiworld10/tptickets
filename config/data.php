<?php

/* BACK */
define('ROOT', dirname(__DIR__).'/');
define('VIEWS', ROOT . '/views');
define('ADMIN_VIEWS', ROOT . '/views/admin');
define('IMG_UPLOADS', ROOT. '/img');
define('VIEWS_ROOT', ROOT . '/views/');


/* FRONT */
define('FRONT_ROOT', 'http://localhost/tptickets');
define('ADMIN_FRONT_ROOT', FRONT_ROOT . '/views/admin');
define('IMG_FRONT_ROOT', FRONT_ROOT . '/img');
define('CSS_PATH', FRONT_ROOT . '/content/css');
define('HEADER','header.php');
define('NAVBAR','navbar.php');
define('MENUADMIN', 'menuadmin.php');
define('FOOTER', 'footer.php');


/* MEDIA */
define('IMG_UPLOADS_PATH', FRONT_ROOT . '/content/uploads/img');
define('MOV_UPLOADS_PATH', FRONT_ROOT . '/content/uploads/movies');

/* DATABASE */
define('DB_HOST', 'localhost');
define('DB_NAME', 'tptickets');
define('DB_USER', 'root');
define('DB_PASS', 'root');