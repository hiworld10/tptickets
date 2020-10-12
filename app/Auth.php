<?php 

namespace app;

use app\dao\db\PurchaseDAO;
use app\dao\db\UserDAO;

/**
 * Clase encargada de generar y destruir sesiones, así como para determinar si hay usuarios 
 * en sesión o no, y su tipo (regular o admin).
 */
class Auth
{
    /**
     * Crea una nueva sesión almacenando el id y el nombre del usuario logueado.
     * @param  User $user El objecto de tipo User logueado.
     * @return void
     */
    public static function createSession($user) {
        session_regenerate_id(true);
        $_SESSION['tptickets_user_id'] = $user->getId();
        $_SESSION['tptickets_user_name'] = $user->getName();

        if (!self::isAdmin()) {
            PurchaseDAO::initCart();
        }
    }

    /**
     * Destruye la sesión creada.
     * @return void
     */
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

    /**
     * Determina si el id corresponde al usuario logueado.
     * @param  int  $id el id a comparar
     * @return boolean
     */
    public static function isAccountOwner($id)
    {
        return ($id === $_SESSION['tptickets_user_id']);
    }

    /**
     * Obtiene el objeto User correspondiente al usuario logueado.
     * @return User el objeto
     */
    public static function getUser()
    {
        $dao = new UserDAO();

        if (isset($_SESSION['tptickets_user_id'])) {
            return $dao->retrieveById($_SESSION['tptickets_user_id']);
        }
    }

    /**
     * Determina si el usuario logueado es admin.
     * @return boolean
     */
    public static function isAdmin()
    {
        $user = static::getUser();

        if ($user) {
            return $user->getAdmin() == 'true';
        }
    }       
}
