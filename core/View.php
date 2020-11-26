<?php

namespace core;
    
/**
 * Clase que maneja y provee las vistas a lo largo y ancho del programa
 */
class View
{   
    /**
     * Muestra en pantalla el resultado de la función getRenderedTemplate()
     * @param  string $view El string correspondiente a la vista a requirir 
     * (ej. para requerir la página de inicio, se debe pasar 'home/index')
     * @param  array  $data El array con los datos a imprimir en pantalla
     * @return void
     */
    public static function render($view, $data = [])
    {
        echo self::getRenderedTemplate($view, $data);
    }

    /**
     * Obtiene una template de una vista y lo retorna mediante output buffer
     * @param  string $view El string correspondiente a la vista a requirir 
     * (ej. para requerir la página de inicio, se debe pasar 'home/index')
     * @param  array  $data El array con los datos a imprimir en pantalla
     * @return El resultado producto del output buffer
     */
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
