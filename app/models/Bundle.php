<?php

namespace app\models;

class Bundle
{
    private $id;
    private $description;
    private $discount;

    public function __construct($id, $description, $discount)
    {
        $this->id   = $id;
        $this->description = $description;
        $this->discount = $discount;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDiscount()
    {
        return $this->discount;
    }
}
