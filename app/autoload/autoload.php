<?php 
namespace app\autoload;

class Autoload {
	
	public static function start() {
		spl_autoload_register(function($className) {
            $className = strtolower($className);
			$path = str_replace("\\", '/', ROOT . $className) . ".php";
            //echo $path  . '<br>';
			require($path);
		});
	}
}
?>