<?php

namespace app\controllers;

use app\Auth;
use app\utils\Flash;

/**
 * Clase abstracta base que extiende del core Controller, hace que cualquier controladora que la extienda pueda requerir que exista un usuario en sesión previo a ejectuar cualquier método propio. Ideal para ocultar funcionalidades de cualquier tipo, a nivel usuario regular o administrador.
 */
abstract class Authentication extends \core\Controller
{
    /**
     * Redirecciona a pagina de login si no encuentra un usuario regular en sesión.
     * @return void
     */
    protected function requireUserLogin(
        $flash_message = 'Debes iniciar sesión para ver esta página')
    {
        if (!Auth::getUser()) {
            Flash::addMessage($flash_message, Flash::INFO);
            $this->redirect('/users/login');
        }
    }

    /**
     * Redirecciona a la página de inicio si no encuentra un administrador en sesión. A contrario de requireUserLogin(), envía a la página de inicio sin dar pista de que el link introducido pueda tratarse de uno que requiera de privilegios para accederlo.
     * @return void
     */
    protected function requireAdminLogin()
    {
        if (!Auth::isAdmin()) {
            $this->redirect('/');
        }
    }
}
