<?php 
namespace controllers;

use model\User as M_User;
use dao\lists\UserDAO as UserDAO;


class UserController {

	private $dao;

	public function __construct() {
		$this->dao = new UserDAO();
	}

	public function addUser($email, $password, $firstname, $lastname, $admin='false')//si no se setea admin->false
	 {
		//checkeo que no exista un usuario con ese email
		if($this->dao->checkEmail($email)){

			//checkeo que password sea mayor a 6 caracteres
			if($this->dao->checkPassword($password)){
				$m_user = new M_User($email, $password, $firstname, $lastname);

				if(isset($admin)){
					$m_user->setAdmin($admin);
				}

				$this->dao->create($m_user);

			}else{
				echo "LA PASSWORD ES MUY CORTA, tiene que tener al menos 6 caracteres";
			}

			
		}else{
			echo "YA EXISTE UN USUARIO CON ESE EMAIL";
		}
		$this->getAll();

	}

	public function getAll(){
		$userArray = $this->dao->retrieveAll(); 
		include ADMIN_VIEWS . '/adminuser.php';
		
	}

	public function getUser($id) {
		$user = $this->dao->retrieveById($id);
		if(isset($user)){
			include ADMIN_VIEWS . '/adminuser.php';
		}
	}


	public function deleteUser($id){

		$this->dao->delete($id);
		$this->getAll();
	}


	public function updateUser($id, $email, $pass, $firstname, $lastname) {
		$updatedUser = new M_User($id, $email, $pass, $firstname, $lstname);
		$this->dao->update($updatedUser);
		$this->getAll();
	}

}

?>
