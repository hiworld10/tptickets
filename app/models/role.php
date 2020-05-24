<?php
namespace app\models;

//Rol? Necesario?
class Role
{

	private $id;
	private $type;
	public $m_user;

	function __construct($id, $type)
	{
		$this->id=$id;
		$this->type=$type;
		$this->m_user=null;
	}


	public function getId()
	{
		return $this->id;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getMUser()
	{
		return $this->m_user;
	}

	public function setId($id)
	{
		$this->id=$id;
	}

	public function setType($type)
	{
		$this->type=$type;
	}

	public function setMUser($m_user)
	{
		$this->m_user=$m_user;
	}


}
?>