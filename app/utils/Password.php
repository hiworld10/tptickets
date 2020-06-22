<?php

namespace app\utils;

/**
 * Clase utilitaria que provee herramientas relacionadas con contraseñas, tales como cifrado, verificacion, etc.
 */
class Password
{
    public static function verify($string, $hash)
    {
        return (password_verify($string, $hash)) ? true : false;
    }

    public static function hasLength($string, $length)
    {
        return (strlen($string) < $length) ? true : false;
    }

    public static function hash($string)
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    public static function match($str1, $str2)
    {
        return ($str1 === $str2) ? true : false;
    }
}
