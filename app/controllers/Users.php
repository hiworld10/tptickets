<?php

namespace app\controllers;

use app\Auth;
use app\Mail;
use app\utils\Flash;
use app\utils\Password;
use core\View;

/**
 * Esta clase provee de métodos que son exclusivos en modo admin, así como también 
 * para usuarios regulares.
 */
class Users extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->user_dao = $this->dao('User');
    }

    /**
     * Lista los usuarios registrados en sistema (modo admin).
     * @return void
     */
    public function index()
    {
        $this->requireAdminLogin();
        $data['users'] = $this->user_dao->retrieveAll();
        View::render('admin/users', $data);
    }

    /**
     * Elimina un usuario en sistema (modo admin)
     * @param  $id El ID del usuario a eliminar
     * @return void
     */
    public function delete($id)
    {
        $this->requireAdminLogin();
        $this->redirectIfRequestIsNotPost('/users');

        //Previene que el primer usuario (el admin) sea borrado.
        if ($id == 1) {
            Flash::addMessage('No es posible eliminar este usuario debido a que este es el administrador principal.', Flash::WARNING);
            $this->redirect('/users');
        }

        $this->handleDeleteCascadeConstraint($this->user_dao, $id);
        $this->redirect('/users');
    }

    /**
     * Permite la edición de los datos de perfil.
     * @param  array  $data El arreglo que contiene los datos a editar. Por defecto, 
     * es vacío
     * @return void
     */
    public function editProfile($data = [])
    {
        // La modificación de datos como admin debe hacerse dentro del menú admin
        if (Auth::isAdmin()) {
            $this->redirect('/');    
        }

        $this->requireUserLogin();

        $data['user'] = Auth::getUser();

        if (isset($data['user'])) {
            View::render('users/edit_profile', $data);
        }
    }

    /**
     * Permite la edición de los datos de usuario en modo admin.
     * @param         $id   El ID del usuario a modificar
     * @param  array  $data El arreglo que contiene los datos a editar. Por defecto, 
     * es vacío
     * @return void
     */
    public function editAsAdmin($id, $data = [])
    {
        $this->requireAdminLogin();

        $data['user'] = $this->user_dao->retrieveById($id);

        if (isset($data['user'])) {
            View::render('admin/users', $data);
        }
    }

    /**
     * Función que permite el inicio de sesión de un usuario. Dependiendo de si su 
     * request es por medio de get o post, muestra la pantalla para introducir las 
     * credenciales o las verifica en la base de datos, y genera una nueva sesión en 
     * caso de que sean válidas.
     * @return void
     */
    public function login()
    {
        // Permite prevenir que se muestre la vista de login si ya hay un usuario en sesión
        if (Auth::getUser()) {
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            //Almacenar datos de formulario en el arreglo asociativo $data, para mostrar la informacion introducida previamente en caso de no ser correcta y asi permitir que el usuario la corrija mas rapidamente
            $data = [
                'email' => '',
            ];
            //Cargar vista
            View::render('users/login', $data);
        } else {
            //Procesar formulario
            //Sanitizar datos de POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Iniciar arreglo de datos con la informacion obtenida
            $data = [
                'email' => trim($_POST['email']),
            ];

            //Para mayor seguridad, las contraseñas se procesan aparte, si no son validadas correctamente, no seran mostradas en su correspondiente campo cuando se muestre nuevamente el formulario de registracion
            $password = $_POST['password'];

            //Verificar e-mail
            if (empty($data['email'])) {
                $data['errors']['email_err'] = "Debés introducir tu e-mail asociado con tu cuenta";
            }

            if (empty($password)) {
                $data['errors']['password_err'] = "Debés introducir tu contraseña";
            }
            
            //Si no se encontraron errores, proceder a la autenticidad de las credenciales
            if (empty($data['errors'])) {
                $user = $this->user_dao->authenticate($data['email'], $password);
                if ($user) {
                    //Si las credenciales son validas, se crea la sesion
                    Auth::createSession($user);
                    //Mensaje de bienvenida
                    Flash::addMessage('Bienvenido de nuevo, ' . $user->getName());
                    //Redireccionar al home
                    $this->redirect('/');
                } else {
                    //Mostrar de nuevo el formulario de login si no hubo inicio de sesión exitoso
                    Flash::addMessage('Usuario o contraseña incorrectos. Intentalo de nuevo', Flash::WARNING);
                    //$data['errors']['login_failed'] = "Usuario o contraseña incorrectos";
                    View::render('users/login', $data);
                }
                //Caso contrario, mostrar nuevamente el formulario de login
            } else {
                View::render('users/login', $data);
            }
        }
    }

    /**
     * Destruye la presente sesión y redirecciona a la pantalla de inicio.
     * @return void
     */
    public function logout()
    {
        Auth::destroySession();
        $this->redirect('/');
    }

    /**
     * Permite registrar a un nuevo usuario, tanto de manera regular como en modo admin. 
     * ependiendo de si su request es por medio de get o post, muestra la pantalla para 
     * introducir los datos de registro o los almacenará en la base de datos.
     * @return void
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Permite prevenir que se muestre la vista de login si ya hay un usuario en sesión
            if (Auth::getUser()) {
                $this->redirect('/');
            }
            //Almacenar datos de formulario en el arreglo asociativo $data, para mostrar la informacion introducida previamente en caso de no ser correcta y asi permitir que el usuario la corrija mas rapidamente
            $data = [
                'name'    => '',
                'surname' => '',
                'email'   => '',
            ];

            //Cargar vista
            View::render('users/register', $data);
        } else {
            //Procesar formulario
            //Sanitizar datos de POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Iniciar arreglo de datos con la informacion obtenida
            $data = [
                'name'    => ucwords(trim($_POST['name'])),
                'surname' => ucwords(trim($_POST['surname'])),
                'email'   => trim($_POST['email']),
            ];

            //Para mayor seguridad, las contraseñas se procesan aparte, si no son validadas correctamente, no seran mostradas en su correspondiente campo cuando se muestre nuevamente el formulario de registracion
            $password         = $_POST['password'];
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
            }

            if ($this->user_dao->retrieveByEmail($data['email'])) {
                $data['errors']['email_err'] = "El e-mail introducido ya está asociado con una cuenta en nuestro sistema";
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email_err'] = "El e-mail introducido no es válido";                
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
                $data['password']         = $password;
                $data['confirm_password'] = $confirm_password;
                if (isset($_POST['admin'])) {
                    $data['is_admin'] = 'true';
                }
                $this->user_dao->create($data);
                if (Auth::isAdmin()) {
                    Flash::addMessage('Usuario agregado.');
                    $this->redirect('/users');
                } else {
                    (new Mail())->sendWelcomeMessage($data['email'], ['name' => $data['name']]);
                    
                    Flash::addMessage('Tu cuenta fue registrada con éxito. Iniciá sesión para continuar.');
                    $this->redirect('/users/login');
                }
            } else {
                if (Auth::isAdmin()) {
                    View::render('admin/users', $data);
                } else {
                    View::render('users/register', $data);
                }
            }
        }
    }

    /**
     * Muestra los datos del perfil del usuario.
     * @return void
     */
    public function showProfile()
    {
        $this->requireUserLogin();

        $user = Auth::getUser();

        if ($user) {
            $data['user'] = $user;
            View::render('users/show_profile', $data);
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Actualiza los datos del usuario.
     * @param  $id El ID del usuario a actualizar
     * @return void
     */
    public function update($id)
    {
        $this->redirectIfRequestIsNotPost('/users');

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Iniciar arreglo de datos con la informacion obtenida
        $data = [
            'name'    => ucwords(trim($_POST['name'])),
            'surname' => ucwords(trim($_POST['surname'])),
            'email'   => trim($_POST['email']),
            'id_user' => $id,
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

        // Solo si se encuentra un usuario válido se realiza esta operación (caso contrario estaríamos llamando a la función getId() en una varible nula)
        if ($user) {
            if ($user->getId() != $id) {
                $data['errors']['email_err'] = "El e-mail introducido ya está asociado con una cuenta en nuestro sistema";
            }
        }

        //Si se dejaron en blanco los campos para contraseña, no se procesará dicha información y sólo se actualizarán los otros datos correspondientes al usuario
        if (!empty($_POST['password']) || !empty($_POST['confirm_password'])) {
            $password         = $_POST['password'];
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
                $data['password']         = $password;
                $data['confirm_password'] = $confirm_password;
                $this->user_dao->update($data);
            } else {
                $this->user_dao->updateWithoutPassword($data);
            }

            if (Auth::isAdmin()) {
                Flash::addMessage('Usuario actualizado.');
                $this->redirect('/users');
            } else {
                Flash::addMessage('Tus datos han sido actualizados.');
                $this->redirect('/users/show-profile');
            }
        } else {
            if (Auth::isAdmin()) {
                //Se obtiene nuevamente la info en la BD del usuario para mostrar los campos en el formulario
                $data['user'] = $this->user_dao->retrieveById($id);
                View::render('admin/users', $data);
            } else {
                $this->editProfile($data);
            }
        }
    }
}
