<?php

namespace core;

use \app\utils\StringUtils;
use app\utils\Flash;

/**
 * Controladora base de la cual otras extenderán. Provee las funcionalidades básicas de carga de objetos con acceso a modelos (DAO) y vistas.
 */
abstract class Controller
{
    /**
     * Instancia un DAO. Su tipo dependerá del parámetro pasado
     * @param  string $dao El tipo de DAO a instanciar (ej. para instanciar un 
     * ArtistDAO, el string debe ser 'Artist')
     * @return La instancia del DAO
     */
    protected function dao($dao)
    {
        $dao       = StringUtils::convertToStudlyCaps($dao) . 'DAO';
        $namespace = 'app\dao\db\\';
        $file      = '../app/dao/db/' . $dao . '.php';
        if (file_exists($file)) {
            $class = $namespace . $dao;
            return new $class;
        }
    }

    /**
     * Redirecciona a un URL específico
     * @param  string $url La url a redireccionar. Por defecto, es la pantalla de home
     * @return void
     */
    protected function redirect($url = '/')
    {
        header('Location: ' . FRONT_ROOT . $url, true, 303);
        exit;
    }

    /**
     * Previene entrar a una url si el request no es mediante POST
     * @param  string $url La url a redireccionar. Por defecto, es la pantalla de home
     * @return
     */
    protected function redirectIfRequestIsNotPost($url = '/')
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->redirect($url);
        }
    }

    /**
     * Maneja una posible excepción al intentar borrar un registro en la base de datos que está ligado a otros (Ej. un usuario que ya tiene compras registradas)
     * @param  DAO $dao El DAO que accede a una tabla de la base de datos
     * @param  int $id  El id del registro a eliminar
     * @return void
     */
    protected function handleDeleteCascadeConstraint($dao, $id)
    {
        try {
            $dao->delete($id);
            Flash::addMessage("Elemento eliminado.");
        } catch (\PDOException $e) {
            Flash::addMessage("No es posible ejecutar esta operación. Mensaje: " . $e->getMessage(), Flash::WARNING);
        }
    }
}
