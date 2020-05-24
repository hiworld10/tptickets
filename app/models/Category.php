<?php
namespace app\models;

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

	public function setId($id)
	{
		$this->id=$id;
	}

	public function setType($type)
	{
		$this->type=$type;
	}
}
?>