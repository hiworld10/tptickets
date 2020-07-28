<?php

namespace app\models;

class Purchase
{
    private $id;
    private $user_id;
    private $total;
    private $date;
    private $purchase_line_arr;

    public function __construct($id, $user_id, $total, $date, $purchase_line_arr)
    {
        $this->id                = $id;
        $this->user_id         = $user_id;
        $this->total             = $total;
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
    
    public function getTotal()
    {
        return $this->total;
    }

    public function getPurchaseLineArr()
    {
        return $this->purchase_line_arr;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
