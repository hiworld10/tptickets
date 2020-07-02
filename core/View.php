<?php

namespace core;

class View
{
    public static function render($view, $data = [])
    {
        echo self::getRenderedTemplate($view, $data);
    }

    public static function getRenderedTemplate($view, $data = [])
    {
        $file = VIEWS_ROOT . $view . '.php';
        if (file_exists($file)) {
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new \Exception('Archivo de vista no encontrado en la ruta ' . $file);
        }
    }
}
