<?php

namespace model;


/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:06
 */
class Artist
{

	private $id;
	private $name;

//Codigo comentado para realizar una prueba
	function __construct($id, $name)
	{
		$this->id=$id;
		$this->name=$name;
	}


	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setId($val)
	{
		$this->id=$val;
	}

	public function setName($val)
	{
		$this->name=$val;
	}

}
?>