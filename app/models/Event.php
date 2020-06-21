<?php

namespace app\models;

use app\models\Category;

class Event
{
    private $id;
    private $name;
    //No se debe explicitar el tipo de clase dentro del atributo propio
    private $category;
    private $image;

    public function __construct($id, $name, Category $category, $image) //Si en los parametros

    {
        $this->id       = $id;
        $this->name     = $name;
        $this->category = $category;
        $this->image    = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImage()
    {
        return $this->image;
    }
}
