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
          
     }

     /**
      * Inicio por defecto del sitio.
      *
      * @method index
      * @param $_user, $_pass
      *
      */
     public function index() {

          $artistController= new ArtistController();
          
          $artistArray = $artistController->getAll();

          include_once VIEWS . '/home.php';

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
