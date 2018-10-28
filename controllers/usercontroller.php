<?php 
namespace controllers;

use model\User as M_User;
use dao\lists\UserDAO as List_UserDAO;
use dao\db\UserDAO as DB_UserDAO;


class UserController {

	private $dao;

	public function __construct() {
		$this->dao = new DB_UserDAO();
	}

	public function addUser($email, $password, $firstname, $lastname, $admin='false')//si no se setea admin->false
	{
		echo $admin; 
		//checkeo que no exista un usuario con ese email
		if($this->checkEmail($email)){

			//checkeo que password sea mayor a 6 caracteres
			if($this->checkPassword($password)) {
				$m_user = new M_User(null, $email, $password, $firstname, $lastname, $admin);

				if(isset($admin)){
					$m_user->setAdmin($admin);

					$this->dao->create($m_user);

				}else{
					echo "LA PASSWORD ES MUY CORTA, tiene que tener al menos 6 caracteres";
				}


			}else{
				echo "YA EXISTE UN USUARIO CON ESE EMAIL";
			}
			$this->getAll();

		}
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


	public function updateUser($id, $email, $pass, $firstname, $lastname, $admin='false') {
		$updatedUser = new M_User($id, $email, $pass, $firstname, $lastname, $admin);
		$this->dao->update($updatedUser);
		$this->getAll();
	}

	//La labor de corroborar los datos deberia ser de la controladora
	public function checkEmail($email) {
		$check=true;
		if (isset($_SESSION["users"])) {
			$this->list = $_SESSION["users"];

			foreach ($this->list as $key => $value) {
				if ($email == $value->getEmail()) {
					return false;
				}
			}
		}
		return $check;
		
	}

	public function checkPassword($pass){

	//strlen cuenta la cantidad de caracteres String
	//en este caso vamos a restringir la pass a mas de 6 caracteres 
		if(strlen ($pass) < 6){
			return false;
		}

		return true;
	}

}

?>
