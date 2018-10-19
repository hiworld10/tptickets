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
	public $m_band;


//Codigo comentado para realizar una prueba
/*	function __construct($id, $name)
	{
		$this->id=$id;
		$this->name=$name;
		//$this->m_band=$m_band;
	}*/

	function __construct() {
		
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getM_Band()
	{
		return $this->m_band;
	}



	public function setId($val)
	{
		$this->id=$val;
	}

	public function setName($val)
	{
		$this->name=$val;
	}

	public function setM_Band($val)
	{
		$this->m_band=$val;
	}


}
?>