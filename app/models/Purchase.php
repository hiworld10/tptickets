<?php

namespace app\models;

class Purchase
{
    private $id;
    private $date;
    private $purchase_line_arr;

    public function __construct($id, $date, $purchase_line_arr)
    {
        $this->id                = $id;
        $this->date              = $date;
        $this->purchase_line_arr = $purchase_line_arr;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getPurchaseLineArr()
    {
        return $this->purchase_line_arr;
    }
}
