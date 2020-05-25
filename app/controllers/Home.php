<?php 

namespace app\controllers;

use app\models\User;
use app\controllers\Users;
use app\controllers\Artists;
use app\controllers\Calendars;

class Home {

    private $user;
    private $calendar;

    function __construct() {
        $this->userController = new Users();
        $this->calendarController = new Calendars();
    }

    public function index() {
        $calendarArray=$this->calendarController->getAll();
        require VIEWS_ROOT . '/home/index.php';
    }

    public function login($email = null, $password = null) {

        $showHome = false; // Esto se vuelve true solo si hay un usuario logueado.

        // Verifico si existe un usuario logueado. Le paso la responsabilidad a UserController de verificarlo
        if($user = $this->userController->checkSession()) {
              $showHome = true;

        } else {

        // Si no hay usuario logueado pero viene un usuario como parametro, es un intento de logueo.
            if(isset($email)) {

            // Intento loguear. Le paso la responsabilidad a UserController. Si es true, muetro home. Caso contrario sigo...
                if($user = $this->userController->login($email, $password)) {
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

    //busca por nombre artista, nombre evento, lugar
    public function search($string) {

        $calendarArray= $this->calendarController->getByString($string);

        if($calendarArray != null) { 
            //lo encontro lo muestro
            require VIEWS_ROOT . '/home/search.php';
        } else {
            print_r("NO SE ENCONTRARON RESULTADOS");
            $this->index();
        }
    }

    public function getCalendar($id_calendar) {
        
        $calendarArray=array();//  la vista search esta codeada para que reciba un array
        $calendar= $this->calendarController->getById($id_calendar);
        array_push($calendarArray, $calendar);
        if($calendarArray != null) {
            
            require VIEWS_ROOT . '/home/search.php';

        } else {
            $this->index();
        }
    }
}
