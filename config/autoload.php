<?php 
namespace config;

class Autoload {
	
	public static function start(){
		spl_autoload_register(function($className){

			$path = str_replace("\\", '/', ROOT.$className) . ".php";
			$path = strtolower($path);
			include_once($path);
		});
	}
}
?>