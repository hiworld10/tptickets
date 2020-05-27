<?php 

namespace app\controllers;

use app\controllers\Home;

class Users extends \core\Controller {

    public function __construct() {
        $this->user_dao = $this->dao('User');
    }

    public function index() {
        echo "Users controller index method called.";
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            //Almacenar datos de formulario en el arreglo asociativo $data, para mostrar la informacion introducida previamente en caso de no ser correcta y asi permitir que el usuario la corrija mas rapidamente
            $data = [
                'name' => '',
                'surname' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'surname_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //Cargar vista
            $this->view('users/register', $data);
        } else {
            //Procesar formulario
            //Sanitizar datos de POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Iniciar arreglo de datos con la informacion obtenida
            $data = [
                'name' => ucwords(trim($_POST['name'])),
                'surname' => ucwords(trim($_POST['surname'])),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'name_err' => '',
                'surname_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
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
