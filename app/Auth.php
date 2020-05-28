<?php 

namespace app;

class Auth
{
    public static function createSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getName();
        if ($user->getAdmin() == 'true') {
            echo "Admin is true";
            $_SESSION['is_admin'] = $user->getAdmin();
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

    public static function isUserLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function isAdminLoggedIn()
    {
        return isset($_SESSION['is_admin']);
    }
}

 ?>