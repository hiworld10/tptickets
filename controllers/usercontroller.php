<?php 
namespace controllers;

use model\User as M_User;
use dao\lists\UserDAO as List_UserDAO;
use dao\db\UserDAO as DB_UserDAO;


class UserController {

	private $dao;
	private $passwordLength = 6;

	public function __construct() {
		$this->dao = new DB_UserDAO();
	}

	public function addUser($email, $password, $firstname, $lastname, $admin='false')//si no se setea admin->false
	{

		//checkeo que no exista un usuario con ese email
		if($this->checkEmail($email)) {
			//checkeo que password sea mayor a 6 caracteres
			if($this->checkPassword($password)) {
				$m_user = new M_User(null, $email, $password, $firstname, $lastname, $admin);

				if(isset($admin)){
					$m_user->setAdmin($admin);
					$this->dao->create($m_user);
				}

			} else echo "LA PASSWORD ES MUY CORTA, tiene que tener al menos 6 caracteres";
			
		} else echo "YA EXISTE UN USUARIO CON ESE EMAIL";
		
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


	public function updateUser($id, $email, $pass, $firstname, $lastname, $admin='false') {

		/*Aca no se va a chequear el email porque en caso de que ese campo no sea el que se quiera modificar haria que se generen conflictos ya que ya va a existir un usuario con ese email, por lo tanto determine que el email no se pueda editar (readonly)*/
		
		//checkeo que password sea mayor a 6 caracteres
		if($this->checkPassword($pass)) {
			$updatedUser = new M_User($id, $email, $pass, $firstname, $lastname, $admin);

			if(isset($admin)){
				$updatedUser->setAdmin($admin);
				$this->dao->update($updatedUser);
			}



		} else echo "LA PASSWORD ES MUY CORTA, tiene que tener al menos 6 caracteres";

		$this->getAll();
	}

	//corregido 28/10 bd
	public function checkEmail($email) {
		$check=true;
		$arrayUsers=$this->dao->retrieveAll();

		if (isset($arrayUsers)) {

			foreach ($arrayUsers as $key => $value) {
				if ($email == $value->getEmail()) {
					$check=false;
				}
			}
		}
		return $check;
	}

	//strlen cuenta la cantidad de caracteres String
	//en este caso vamos a restringir la pass a mas de 6 caracteres
	public function checkPassword($pass){
		//el operador ternario es mas kool
		return ((strlen ($pass) < $this->passwordLength) ? false : true);
	}


	public function login($email, $password){
		$arrayUsers=$this->dao->retrieveAll();
		if(!$this->checkEmail($email)){
		//me fijo si el email esta en la bd
			foreach ($arrayUsers as $key => $value) {
				if ($email == $value->getEmail()) {
					if($password == $value->getPassword())
					{
						//si es admin va a home sino a admin
						//TENDRIA Q SER AL REVES
						if($value->getAdmin()== "true")
						{
							include VIEWS.'/home.php';

						}else{							
							
							include ADMIN_VIEWS.'/admin.php';
							
						}
					}else{
						print_r("Contraseña erronea. Intente de nuevo");
						include VIEWS. '/login.php';
					}
				}
			}
		}else{
			print_r("No existe un usuario con ese email. Intente de nuevo");
			include VIEWS. '/login.php';
		}
		
	}


	public function index(){
		include VIEWS_ROOT. '/login.php';
	}


}

?>
