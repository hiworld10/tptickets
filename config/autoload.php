<?php 
namespace config;

class Autoload {
	
	public static function start(){
		spl_autoload_register(function($nombreclase){

			$ruta=  str_replace("\\", '/', ROOT.$nombreclase) . ".php";
			$ruta = strtolower($ruta);
			include_once($ruta);
		});
	}
}


?>