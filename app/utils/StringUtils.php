<?php 

namespace app\utils;
/**
 * Clase utilitaria para manipular y devolver strings.
 */
class StringUtils
{
    /**
     * Convierte en camel case el string correspondiente a la funcion de la controladora a llamar
     * 
     * @param  string
     * @return string
     */
    public static function convertToCamelCase($string) {
        return lcfirst(self::convertToStudlyCaps($string));
    }

    /**
     * Capitaliza la inicial de cada caracter posterior a un '-' del string correspondiente a la funcion de la controladora a llamar. Se utiliza en conjunto con la funcion convertToCamelCase().
     *
     * De este modo, en el URL se podra llamar al metodo deseado separando palabras con un '-'. Ej: 'artists/get-all'
     * 
     * @param  string
     * @return string
     */
    public static function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public static function lowercaseAndUnderscores($string) {
        return str_replace(' ', '_', strtolower($string));
    }
}

 ?>