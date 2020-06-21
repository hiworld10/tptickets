<?php

namespace app\models;

class User
{
    private $id;
    private $email;
    private $password;
    private $name;
    private $surname;
    private $admin;
    //private $m_purchase;

    public function __construct($id, $email, $password, $name, $surname, $admin)
    {
        $this->id       = $id;
        $this->email    = $email;
        $this->password = $password;
        $this->name     = $name;
        $this->surname  = $surname;
        $this->admin    = $admin;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    //Utilizado para la conversión de string a int en la base de datos
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }
}
