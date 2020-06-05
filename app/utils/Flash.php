<?php 

namespace app\utils;

/**
 * Clase que se encarga de mostrar notificaciones que sólo serán visibles en un sólo request, mostrando información relevante para el usuario.
 */
class Flash
{   
    /**
     * constantes para mostrar colores diferentes según el tipo de notificación
     * SUCCESS: verde
     * INFO: azul
     * WARNING: amarillo
     */
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';

    public static function addMessage($message, $type = 'success') {
        //Inicializa el arreglo de mensajes en sesión
        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [];
        }
        //Agrega el mensaje al arreglo
        $_SESSION['flash_messages'][] = ['body' => $message, 'type' => $type];
    }

    public static function getMessages() {
        //Si está seteado el arreglo de mensajes, se almacenan en una variable, se quitan de sesión y se retorna dicha variable
        if (isset($_SESSION['flash_messages'])) {
            $messages = $_SESSION['flash_messages'];
            unset($_SESSION['flash_messages']);
            return $messages;
        }
    }
}
 ?>