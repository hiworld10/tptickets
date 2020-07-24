<?php

namespace app\models;

use app\models\Bundle;
use app\models\Category;

class Event
{
    private $id;
    private $name;
    private $category;
    private $image;
    private $bundle; // nullable

    public function __construct($id, $name, Category $category, $image)
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

    public function getBundle()
    {
        return $this->bundle;
    }

    public function setBundle(Bundle $bundle)
    {
        $this->bundle = $bundle;
    }
}
