<?php
namespace model;




/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:08
 */
class User
{
	private $id;
	private $email;
	private $password;
	private $firstname;
	private $lastname;
	private $admin;
	public $m_purchasegetFirstnameemail;

	function __construct($email, $password, $firstname, $lastname)
	{
		$this->id=null;
		$this->email = $email;
		$this->password = $password;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->admin= null;
	}


	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getFirstname()
	{
		return $this->firstname;
	}

	public function getLastname()
	{
		return $this->lastname;
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id=$id;
	}


	public function setEmail($email)
	{
		$this->email=$email;
	}

	public function setPassword($password)
	{
		$this->password=$password;
	}

	public function setFirstname($firstname)
	{
		$this->firstname=$firstname;
	}

	public function setLastname($lastname)
	{
		$this->lastname=$lastname;
	}


	public function getAdmin()
	{
		return $this->admin;
	}



	public function setAdmin($admin)
	{
		$this->admin=$admin;
	}

}
?>