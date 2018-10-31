<?php 
namespace controllers;

use model\User as M_User;

use controllers\UserController as UserController;

use controllers\ArtistController as ArtistController;

/**
 *
 */
class HomeController
{
     private $user;

     function __construct() {
          $this->userController = new UserController();
     }

     /**
      * Inicio por defecto del sitio.
      *
      * @method index
      * @param $_user, $_pass
      *
      */

    public function index(){
      include_once VIEWS_ROOT. '/home.php';
    }


     public function login($email= null, $password= null) {

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
          

          if($showHome){
                if($user->getAdmin() == "true"){
                  include_once VIEWS_ROOT. '/home.php';
                }else{
                  include_once ADMIN_VIEWS. '/admin.php';
                }
          }else{
            //vista login
               include_once VIEWS_ROOT . '/user';
          }



          //por el momento rompo la sesion deberia asignarse a un boton
          $this->userController->logout();

     }

     public function addUser($name, $surname, $nationality = '', $state = '', $city = '', $birthdate = '', $email, $pass, $file) {

          // Codifiacacion de contraseña
          //$pass = md5($pass);

          $user = new M_User('', $name, $surname, $nationality, $state, $city, $birthdate, $email, $pass, $file);

          try {
               if($this->userController->add($user))
                    $success = "Gracias por registrarte. Ya podes iniciar sesión.";
               else
                    $alert = "Ocurrió un error al crear la cuenta. Vuelva a intentar.";
          } catch(\PDOException $ex) {
               $alert =  $ex->errorInfo['2'];
          }

          include_once VIEWS . '/header.php';

          include_once VIEWS . '/login.php';

          include_once VIEWS . '/footer.php';
     }
}
