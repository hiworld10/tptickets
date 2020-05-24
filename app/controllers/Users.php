<?php 

namespace app\controllers;

use app\models\User;
use app\dao\lists\UserDAO as List_UserDAO;
use app\dao\db\UserDAO as DB_UserDAO;
use app\controllers\Home;

class Users {

	private $dao;
	private $passwordLength = 6;

	public function __construct() {
		$this->dao = new DB_UserDAO();
		
	}

    public function index() {
        $userArray = $this->dao->retrieveAll();
        require ADMIN_VIEWS . '/adminuser.php';
        
    }

	public function addUser($user) {

		try {
			$this->dao->create($user);
			if(!$this->checkSession() )// si no esta en session significa que no es admin, muestro home
            {	
            	$this->setSession($user);
            	$home = new Home();
            	$home->index();
              }else{
             	$this->index();// es admin entonces muestro view/adminuser
             }


			return true;
		} catch(\PDOException $ex) {
			throw $ex;
		}
	}

	public function getUser($id) {
		$user = $this->dao->retrieveById($id);
		if(isset($user)){
			require ADMIN_VIEWS . '/adminuser.php';
		}
	}

	public function updateUser($id, $email, $pass, $firstname, $lastname, $admin='false') {

		/*Aca no se va a chequear el email porque en caso de que ese campo no sea el que se quiera modificar haria que se generen conflictos ya que ya va a existir un usuario con ese email, por lo tanto determine que el email no se pueda editar (readonly)*/
		
		//checkeo que password sea mayor a 6 caracteres
		if($this->checkPassword($pass)) {
			$updatedUser = new User($id, $email, $pass, $firstname, $lastname, $admin);

			if(isset($admin)){
				$updatedUser->setAdmin($admin);
				$this->dao->update($updatedUser);
			}

		} else echo "LA PASSWORD ES MUY CORTA, tiene que tener al menos 6 caracteres";

		$this->index();
	}

    public function deleteUser($id) {

        $this->dao->delete($id);
        $this->index();
    }

	//corregido 28/10 bd
	public function checkEmail($email){
		$check=true;
		$arrayUsers=$this->dao->retrieveAll();

		if (isset($arrayUsers)) {

			foreach ($arrayUsers as $key => $value) {
				if ($email == $value->getEmail()) {
					$check = false;
				}
			}
		}
		return $check;
	}

	//strlen cuenta la cantidad de caracteres String
	//en este caso vamos a restringir la pass a mas de 6 caracteres
	public function checkPassword($pass) {
		//el operador ternario es mas kool
		return ((strlen ($pass) < $this->passwordLength) ? false : true);
	}

	public function login($email, $password) {

		$user =  $this->dao->retrieveByEmail($email);

		if($user) {
			if($user->getPassword() == $password) {
				$this->setSession($user);
				return $user;
			}
		}
		return false;
	}

    //TODO: two declared indexes, needs to fix
	public function loginScreen() {
		require VIEWS_ROOT. '/login.php';
	}

	public function signup() {
		require VIEWS_ROOT. '/signup.php';
	}

	public function adminview() {
		require ADMIN_VIEWS. '/admin.php';
	}

  	/* Este método verifica si existe un usuario en sesion y en caso
      * afirmativo lo toma de la base de datos y compara contraseñas.
      * Esto lo hace con el fin de asegurar que si cambio algun dato
      * obtiene la información actualizada.
      */
  	public function checkSession() {
  		if (session_status() == PHP_SESSION_NONE)
  			session_start();

  		if(isset($_SESSION['userLogedIn'])) {

  			$user = $this->dao->retrieveByEmail($_SESSION['userLogedIn']->getEmail());

  			if($user->getPassword() == $_SESSION['userLogedIn']->getPassword())
  				return $user;

  		} else {
  			return false;
  		}
  	}

    public function isUserAdmin() {
        /*Si $user es verdadero, verifico que el atributo admin sea "true"*/
        $user = $this->checkSession();
        if($user) {
            return (($user->getAdmin() == "true") ? true : false); 
        }
    }

  	public function setSession($user) {
  		$_SESSION['userLogedIn'] = $user;
  	}

  	public function logout() {

  		if (session_status() == PHP_SESSION_NONE)
  			session_start();

  		unset($_SESSION['userLogedIn']);
	
  		$homeController = new Home();
  		$homeController->index();
  	}
}

?>
