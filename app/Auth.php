<?php 

namespace app;

use app\dao\db\UserDAO;

class Auth
{
    public static function createSession($user) {
        session_regenerate_id(true);
        $_SESSION['tptickets_user_id'] = $user->getId();
        $_SESSION['tptickets_user_name'] = $user->getName();
        if ($user->getAdmin() == 'true') {
            $_SESSION['tptickets_is_admin'] = $user->getAdmin();
        }
    }

    public static function destroySession() {
        //Desligar todas las variables en $_SESSION
        $_SESSION = [];
        //Borrar la cookie en sesion
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(), 
                '', 
                time() - 42000,
                $params['path'], 
                $params['domain'],
                $params['secure'], 
                $params['httponly']
            );
        }
        //Finalmente, destruir la sesion
        session_destroy();
    }

    public static function isAccountOwner($id)
    {
        return ($id === $_SESSION['tptickets_user_id']);
    }

    public static function getUser()
    {
        $dao = new UserDAO();

        if (isset($_SESSION['tptickets_user_id'])) {
            return $dao->retrieveById($_SESSION['tptickets_user_id']);
        }
    }

    public static function isAdmin()
    {
        $user = static::getUser();

        if ($user) {
            return $user->getAdmin() == 'true';
        }
    }       
}

 ?>