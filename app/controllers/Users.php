<?php 

namespace app\controllers;

use app\controllers\Home;
use app\utils\Password;
use app\utils\Redirector;

class Users extends \core\Controller {

    public function __construct() {
        $this->user_dao = $this->dao('User');
        //$this->user_m = $this->model('User');
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
                'email' => trim($_POST['email'])
            ];
            //Para mayor seguridad, las contraseñas se procesan aparte, si no son validadas correctamente, no seran mostradas en su correspondiente campo cuando se muestre nuevamente el formulario de registracion
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            //Verificar que los campos de nombre y apellido
            if (empty($data['name'])) {
                $data['errors']['name_err'] = "Debes introducir tu nombre";
            }
            if (empty($data['surname'])) {
                $data['errors']['surname_err'] = "Debes introducir tu apellido";
            }
            //Verificar e-mail, tanto que el campo no este vacio asi como asegurar que no este ya asociado con una cuenta
            if (empty($data['email'])) {
                $data['errors']['email_err'] = "Debes proveer un e-mail";
            } elseif ($this->user_dao->retrieveByEmail($data['email'])) {
                $data['errors']['email_err'] = "El e-mail introducido ya está asociado con una cuenta en nuestro sistema";
            }
            //Validar contraseña
            if (empty($password)) {
                $data['errors']['password_err'] = "Debes introducir una contraseña";
            } elseif (Password::hasLength($password, 6)) {
                 $data['errors']['password_err'] = "La contraseña debe tener al menos 6 caracteres";
            }
            //Validar confirmacion contraseña
            if (empty($confirm_password)) {
                $data['errors']['confirm_password_err'] = "Debes confirmar la contraseña";
            } elseif (!Password::match($password, $confirm_password)) {
                 $data['errors']['confirm_password_err'] = "Las contraseñas no coinciden";
            }

            if (empty($data['errors'])) {
                $data['password'] = $password;
                $data['confirm_password'] = $confirm_password;
                if (isset($_POST['is_admin'])) {
                    $data['is_admin'] = 'true';
                }
                $this->user_dao->create($data);
                $this->redirect('users/success');
            } else {
                $this->view('users/register', $data);
            }
        }
    }

    public function success() {
        $this->view('users/success');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            //Almacenar datos de formulario en el arreglo asociativo $data, para mostrar la informacion introducida previamente en caso de no ser correcta y asi permitir que el usuario la corrija mas rapidamente
            $data = [
                'email' => '',
            ];
            //Cargar vista
            $this->view('users/login', $data);
        } else {
            //Procesar formulario
            //Sanitizar datos de POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Iniciar arreglo de datos con la informacion obtenida
            $data = [
                'email' => trim($_POST['email'])
            ];
            //Para mayor seguridad, las contraseñas se procesan aparte, si no son validadas correctamente, no seran mostradas en su correspondiente campo cuando se muestre nuevamente el formulario de registracion
            $password = $_POST['password'];
            //Verificar e-mail
            if (empty($data['email'])) {
                $data['errors']['email_err'] = "Debes introducir tu e-mail asociado con tu cuenta";
            }
            if (empty($password)) {
                $data['errors']['password_err'] = "debes introducir tu contraseña";
            }
            //Si no se encontraron errores, proceder a la autenticidad de las credenciales
            if(empty($data['errors'])) {
                $user = $this->authenticate($data['email'], $password);
                if ($user) {
                    //Mensaje de bienvenida (mejorarlo con mensajes Flash)
                    $data['login_successful'] = "Sesión iniciada con éxito. Bienvenido, " . $user->getFirstname();
                    //Mostrar el menu de admin si el usuario lo es, o el inicio convencional si no
                    if ($user->getAdmin() == 'false') {
                        $this->view('', $data);
                    } else {
                        $this->view('admin/admin');
                    }
                } else {
                    //Mostrar de nuevo el formulario de login si no hubo inicio de sesión exitoso
                    $data['errors']['login_failed'] = "Usuario o contraseña incorrectos";
                    $this->view('users/login', $data);
                }
              //Caso contrario, mostrar nuevamente el formulario de login  
            } else {
                $this->view('users/login', $data);
            }
        }
    }
    /**
     * Verifica si las credenciales introducidas son validas y retorna el correspondiente usuario en caso de que lo haga exitosamente.
     * @param  string $email    El email
     * @param  password $password La contraseña
     * @return mixed           El objeto User o false
     */
    private function authenticate($email, $password) {
        $user = $this->user_dao->retrieveByEmail($email);
        if ($user->getAdmin() == 'false') {
            return (Password::verify($password, $user->getPassword())) ? $user : false;
        } else {
            //Aqui la contraseña no es verificada ante un hash, debido a que la cuenta de admin esta hardcodeada con una contraseña con pleno texto. Esto debe ser corregido de alguna forma.
            return ($password = $user->getPassword()) ? $user : false;
        }
        return false;
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
