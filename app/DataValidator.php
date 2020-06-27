<?php

namespace app;;

use app\dao\db\UserDAO;
use app\utils\Password;

class DataValidator
{
    public static function newUser($user_data)
    {
        // if (
        //     !array_key_exists('name', $user_data) || 
        //     !array_key_exists('surname', $user_data) || 
        //     !array_key_exists('email', $user_data) || 
        //     !array_key_exists('password', $user_data) || 
        //     !array_key_exists('confirm_password', $user_data) 
        // ) {
        //     throw new \Exception('Required array keys were not found.');
        // }

        $name             = $user_data['name'];
        $surname          = $user_data['surname'];
        $email            = $user_data['email'];
        $password         = $user_data['password'];
        $confirm_password = $user_data['confirm_password'];

        $errors = [];

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Para mayor seguridad, las contraseñas se procesan aparte, si no son validadas correctamente, no seran mostradas en su correspondiente campo cuando se muestre nuevamente el formulario de registracion

        //Verificar que los campos de nombre y apellido
        if (empty($name)) {
            $errors[] = "Debes introducir tu nombre";
        }

        if (empty($surname)) {
            $errors[] = "Debes introducir tu apellido";
        }

        //Verificar e-mail, tanto que el campo no este vacio asi como asegurar que no este ya asociado con una cuenta
        if (empty($email)) {
            $errors[] = "Debes proveer un e-mail";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El e-mail introducido no es válido";
        } else {
            $user_dao = new UserDAO();
            if ($user_dao->retrieveByEmail($email)) {
                $errors[] = "El e-mail introducido ya está asociado con una cuenta en nuestro sistema";
            }
        }

        //Validar contraseña
        if (empty($password)) {
            $errors[] = "Debes introducir una contraseña";
        } elseif (Password::hasLength($password, 6)) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres";
        }
        //Validar confirmacion contraseña
        if (empty($confirm_password)) {
            $errors[] = "Debes confirmar la contraseña";
        } elseif (!Password::match($password, $confirm_password)) {
            $errors[] = "Las contraseñas no coinciden";
        }

        return $errors;
    }
}
