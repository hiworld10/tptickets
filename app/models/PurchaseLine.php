<?php

namespace app\models;

use app\models\Ticket;

class PurchaseLine
{
    private $id;
    private $event_seat_id;
    private $purchase_id;
    private $quantity;
    private $price;
    private $ticket;

    public function __construct($id, $event_seat_id, $quantity, $purchase_id, $price, /*Ticket*/ $ticket)
    {
        $this->id            = $id;
        $this->event_seat_id = $event_seat_id;
        $this->purchase_id   = $purchase_id;
        $this->quantity      = $quantity;
        $this->price         = $price;
        $this->ticket        = $ticket;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function getPurchaseId()
    {
        return $this->purchase_id;
    }
}
