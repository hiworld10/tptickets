<?php

namespace app\utils;

/**
 * Clase utilitaria que provee herramientas relacionadas con contraseñas, tales como cifrado, verificacion, etc.
 */
class Password
{
    /**
     * Verifica que la contraseña proveída le corresponde al hash almacenado en la 
     * base de datos.
     * @param  string $string la contraseña proveída
     * @param  string $hash   el hash a verificar
     * @return boolean
     */
    public static function verify($string, $hash)
    {
        return (password_verify($string, $hash)) ? true : false;
    }

    /**
     * Verifica que la contraseña proveída sea igual o mayor a cierta cantidad de caracteres.
     * @param  string  $string la contraseña proveída
     * @param  int  $length la longitud mínima
     * @return boolean
     */
    public static function hasLength($string, $length)
    {
        return (strlen($string) < $length) ? true : false;
    }

    /**
     * Genera el hash de la contraseña proveída para posteriormente ser almacenada en 
     * la base de datos.
     * @param  string $string la contraseña proveída
     * @return string el hash de la contraseña proveída
     */
    public static function hash($string)
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    /**
     * Nota: Esta función es antigua y ya no es utilizada debido a que no puede hacer uso de 
     * hashes. Esto sólo es útil para comparar contraseñas en pleno texto (inseguro). Dicha 
     * función permanece sólo para referencia.
     *  
     * Compara un string con otro. Devuelve true si ambos coinciden, false de lo contrario.
     * 
     * @param  string $str1 el primer string a comparar
     * @param  string $str2 el segundo string a comparar
     * @return boolean
     */
    public static function match($str1, $str2)
    {
        return ($str1 === $str2) ? true : false;
    }
}
