<?php 

namespace app\controllers;

use app\controllers\Home;
use app\utils\Password;
use app\Auth;
use app\utils\Flash;

class Users extends \app\controllers\Authentication {

    public function __construct() {
        $this->user_dao = $this->dao('User');
    }

    public function index() {
        $this->requireAdminLogin();
        $data['users'] = $this->user_dao->retrieveAll();
        $this->view('admin/users', $data);
    }

    public function show($id) {
        $this->requireUserLogin();
        $user = $this->user_dao->retrieveById($id);
        if ($user) {
            if (Auth::isAccountOwner($user->getId())) {
                $data['user'] = $user;
                $this->view('users/show', $data);
            }    
        } else {
            $this->redirect('');
        }
        
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
                if (isset($_POST['admin'])) {
                    $data['is_admin'] = 'true';
                }
                $this->user_dao->create($data);
                if (Auth::isAdminLoggedIn()) {
                    $this->redirect('users');
                } else {
                    $this->redirect('users/register-success');
                }
            } else {
                if (Auth::isAdminLoggedIn()) {
                    $this->view('admin/users', $data);
                } else {
                    $this->view('users/register', $data);
                }
            }
        }
    }

    public function registerSuccess() {
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
                    //Si las credenciales son validas, se crea la sesion
                    Auth::createSession($user);
                    //Mensaje de bienvenida
                    Flash::addMessage('Bienvenido de nuevo, ' . $user->getName());
                    //Redireccionar al home
                    $this->redirect('');
                } else {
                    //Mostrar de nuevo el formulario de login si no hubo inicio de sesión exitoso
                    Flash::addMessage('Usuario o contraseña incorretos. Intentalo de nuevo', Flash::WARNING);
                    //$data['errors']['login_failed'] = "Usuario o contraseña incorrectos";
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
        if ($user) {
            if ($user->getAdmin() == 'false') {
                return (Password::verify($password, $user->getPassword())) ? $user : false;
            } else {
                //Aqui la contraseña no es verificada ante un hash, debido a que la cuenta de admin esta hardcodeada con una contraseña con pleno texto. Esto debe ser corregido de alguna forma.
                return ($password = $user->getPassword()) ? $user : false;
            }
        }
        return false;
    }

    public function logout() {
        Auth::destroySession();
        $this->redirect('');
    }

    public function delete($id) {
        $this->requireAdminLogin();
        $this->redirectIfRequestIsNotPost('users');
        $this->user_dao->delete($id);
        $this->redirect('users');
    }

    public function update($id) {
        $this->redirectIfRequestIsNotPost('users');

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Iniciar arreglo de datos con la informacion obtenida
        $data = [
            'name' => ucwords(trim($_POST['name'])),
            'surname' => ucwords(trim($_POST['surname'])),
            'email' => trim($_POST['email']),
            'id_user' => $id
        ];

        if (empty($data['name'])) {
            $data['errors']['name_err'] = "Debes introducir un nombre";
        }
        if (empty($data['surname'])) {
            $data['errors']['surname_err'] = "Debes introducir un apellido";
        }
        //Verificar que el campo de e-mail no este vacio
        if (empty($data['email'])) {
            $data['errors']['email_err'] = "Debes proveer un e-mail";
        }
        //Verificar que el email no este asociado con una cuenta de id diferente a la cuenta a actualizar
        $user = $this->user_dao->retrieveByEmail($data['email']);
        if ($user->getId() != $id) {
            $data['errors']['email_err'] = "El e-mail introducido ya está asociado con una cuenta en nuestro sistema";   
        }

        //Si se dejaron en blanco los campos para contraseña, no se procesará dicha información y sólo se actualizarán los otros datos correspondientes al usuario
        if (!empty($_POST['password']) || !empty($_POST['confirm_password'])) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if (Password::hasLength($password, 6)) {
                $data['errors']['password_err'] = "La contraseña debe tener al menos 6 caracteres";
            } 
            if (!Password::match($password, $confirm_password)) {
                $data['errors']['confirm_password_err'] = "Las contraseñas no coinciden";
            }
        }

        if (empty($data['errors'])) {

            if (isset($_POST['admin'])) {
                $data['is_admin'] = 'true';
            }
            if (isset($password) && isset($confirm_password)) {
                $data['password'] = $password;
                $data['confirm_password'] = $confirm_password;
                $this->user_dao->update($data);
            } else {
                $this->user_dao->updateWithoutPassword($data);
            }

            if (Auth::isAdminLoggedIn()) {
                $this->redirect('users');
            } else {
                $this->redirect('users/update-success');
            }
        } else {
            if (Auth::isAdminLoggedIn()) {
                //Se obtiene nuevamente la info en la BD del usuario para mostrar los campos en el formulario
                $data['user'] = $this->user_dao->retrieveById($id);
                $this->view('admin/users', $data);
            } else {
                $this->edit($id, $data);
            }
        }        
    }

    public function updateSuccess() {
        $this->view('users/update_successful');
    }    

    public function edit($id, $data = []) {
        $this->requireUserLogin();
        $data['user'] = $this->user_dao->retrieveById($id);
        if (isset($data['user'])) {

            if (Auth::isAdminLoggedIn()) {
                $this->view('admin/users', $data);

            } else {
                if (Auth::isAccountOwner($data['user']->getId())) {
                    $this->view('users/edit', $data);
                } else {
                    $this->redirect('');
                }
            }
        }
    }
}

?>
