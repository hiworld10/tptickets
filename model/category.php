<?php
namespace model;

/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:07
 */
class Category
{

	private $id;
	private $type;


	function __construct($id, $type)
	{
		$this->id=$id;
		$this->type=$type;
		
	}

	public function getId()
	{
		return $this->id;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getM_Event()
	{
		return $this->m_event;
	}


	public function setId($id)
	{
		$this->id=$id;
	}

	public function setType($type)
	{
		$this->type=$type;
	}

	public function setM_Event($m_event)
	{
		$this->m_event=$m_event;
	}



}
?>