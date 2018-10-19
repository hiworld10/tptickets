<?php
namespace model;
require_once ('Compra.php');



/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:08
 */
class User
{

	private $email;
	private $password;
	private $firstname;
	private $lastname;
	public $m_purchasegetFirstnameemail;

	function __construct($email, $password, $firstname, $lastname)
	{
		$this->email = $email;
		$this->password = $password;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
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

}
?>