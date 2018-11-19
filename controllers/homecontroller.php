<?php 
namespace controllers;

use model\User as M_User;
use controllers\UserController as UserController;
use controllers\ArtistController as ArtistController;
use controllers\CalendarController as CalendarController;
use controllers\EventController as EventController;

/**
 *
 */

//ESTA INDENTACION ES REPULSIVA, CORREGIR
class HomeController {

    private $user;
    private $calendar;

    function __construct() {
        $this->userController = new UserController();
        $this->calendarController = new CalendarController();
        $this->eventController = new EventController();
    }

    public function index() {
        $eventArray=$this->eventController->getAllSelect();
        include_once VIEWS_ROOT. '/home.php';
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
                include_once ADMIN_VIEWS. '/admin.php';
            } else {
                include_once VIEWS_ROOT. '/home.php';
            }   
        } else {
                //vista login
            print_r($alert);
            include_once VIEWS_ROOT. '/login.php';
        }
    }

    public function addUser($email, $password, $firstname, $lastname, $admin='false') {

        // Codifiacacion de contraseña
        //$pass = md5($pass);


        //checkeo que no exista un usuario con ese email
        if($this->userController->checkEmail($email)) {
            //checkeo que password sea mayor a 6 caracteres
            if($this->userController->checkPassword($password)) {
                $m_user = new M_User(null, $email, $password, $firstname, $lastname, $admin);

                if(isset($admin)) {
                    $m_user->setAdmin($admin);
                }

            try {
                if($this->userController->addUser($m_user)) {
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

    // no funca falta hacer las funciones en controladora y antes en los daos
        $calendarArray = $this->calendarController->getCalendarByArtist($string);
        if(!isset($calendarArray)) {
            $calendarArray = $this->calendarController->getCalendarByPlaceEvent($string);
        } else {
            $calendarArray = $this->calendarController->getCalendarByEvent($string);
        }     



        if(isset($calendarArray)) {
                                
            //lo encontro lo muestro
            include_once VIEWS_ROOT. '/search.php';

        } else {
            print_r("NO SE ENCONTRO NINGUNA FECHA");
            include_once VIEWS_ROOT. '/admin.php';
        }
    }


}
