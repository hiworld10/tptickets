<?php

namespace app\models;

class Purchase
{
    private $id;
    private $client_id;
    private $total;
    private $date;
    private $purchase_line_arr;

    public function __construct($id, $client_id, $total, $date, $purchase_line_arr)
    {
        $this->id                = $id;
        $this->client_id         = $client_id;
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

    public function getClientId()
    {
        return $this->client_id;
    }

}
