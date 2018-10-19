<?php

	include_once("../model/Usuario.php");


	$values = $_POST;
	$usuario = new Usuario($values["email"], $values["pass"], $values["nombre"], $values["apellido"]);
	print_r($usuario);
	$arr[0] = $usuario; 
	
	var_dump($arr);


?>