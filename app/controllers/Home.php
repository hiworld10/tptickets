<?php 

namespace app\controllers;

use core\Controller;
use app\controllers\Users;

class Home extends Controller {

    function __construct() {
        $this->user_dao = $this->dao('User');
        $this->calendar_dao = $this->dao('Calendar');
    }

    public function index() {
        $data['calendars'] = $this->calendar_dao->retrieveAll();
        $this->view('home/index', $data);
    }

    //busca por nombre artista, nombre evento, lugar
    public function search($string) {
        $data['calendars'] = $this->calendar_dao->retrieveCalendarsByString($string);

        if($data['calendars'] != null) { 
            $this->view('home/search', $data);
        } else {
            $data['err'] = "No hay resultados.";
            $this->view('', $data);
        }
    }

    public function getCalendar($id_calendar) {
        
        $data['calendars'] = array();//  la vista search esta codeada para que reciba un array
        $calendar = $this->calendar_dao->retrieveById($id_calendar);
        array_push($data['calendars'], $calendar);
        if($data['calendars'] != null) {
            $this->view('home/search', $data);
        } else {
            $this->index();
        }
    }

    public function login($email = null, $password = null) {

        $showHome = false; // Esto se vuelve true solo si hay un usuario logueado.
        $userController = new Users();
        // Verifico si existe un usuario logueado. Le paso la responsabilidad a UserController de verificarlo
        if($user = $userController->checkSession()) {
              $showHome = true;
        } else {
        // Si no hay usuario logueado pero viene un usuario como parametro, es un intento de logueo.
            if(isset($email)) {
            // Intento loguear. Le paso la responsabilidad a UserController. Si es true, muetro home. Caso contrario sigo...
                if($user = $userController->login($email, $password)) {
                  $showHome = true;
                } else {
                  $alert = "Datos incorrectos, vuelva a intentar.";
                }
            }
        }

        if($showHome) {
            if($user->getAdmin() == "true") {
                require ADMIN_VIEWS. '/admin.php';
            } else {
                require VIEWS_ROOT . '/home/index.php';
            }   
        } else {
                //vista login
            print_r($alert);
            require VIEWS_ROOT . '/login.php';
        }
    }

    public function addUser($email, $password, $firstname, $lastname, $admin='false') {

        // Codifiacacion de contraseña
        //$pass = md5($pass);


        //checkeo que no exista un usuario con ese email
        if($this->userController->checkEmail($email)) {
            //checkeo que password sea mayor a 6 caracteres
            if($this->userController->checkPassword($password)) {
                $user = new User(null, $email, $password, $firstname, $lastname, $admin);

                if(isset($admin)) {
                    $user->setAdmin($admin);
                }

            try {

                if($this->userController->addUser($user)) {
                    $success = "Gracias por registrarte. Ya podes iniciar sesión.";
                    
                } else {
                    $alert = "Ocurrió un error al crear la cuenta. Vuelva a intentar.";
                }
            } catch(\PDOException $ex) {
                $alert =  $ex->errorInfo['2'];
            }      

            } else echo "LA PASSWORD ES MUY CORTA, tiene que tener al menos 6 caracteres";

        } else echo "YA EXISTE UN USUARIO CON ESE EMAIL";

    }
}
