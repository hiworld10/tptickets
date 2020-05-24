<?php 
namespace app\autoload;

class Autoload {
	
	public static function start() {
        spl_autoload_register(function($className) {
            $root = dirname(dirname(__DIR__)) . '/';
            $path = $root . str_replace("\\", '/', $className) . ".php";
            //echo $path . '<br>';
            if (is_readable($path)) {
                require($path);
            }
        });
	}
}
?>