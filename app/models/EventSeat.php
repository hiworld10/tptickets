<?php

namespace app\models;

use app\models\SeatType;

class EventSeat
{
    private $id;
    private $calendarId;
    private $seatType;
    private $quantity;
    private $price;
    private $remainder;

    public function __construct($id, $calendarId, SeatType $seatType, $quantity, $price, $remainder)
    {
        $this->id         = $id;
        $this->calendarId = $calendarId;
        $this->seatType   = $seatType;
        $this->quantity   = $quantity;
        $this->price      = $price;
        $this->remainder  = $remainder;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCalendarId()
    {
        return $this->calendarId;
    }

    public function getSeatType()
    {
        return $this->seatType;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getRemainder()
    {
        return $this->remainder;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function hasAvailable($amount)
    {
        return $this->remainder >= $amount;
    }

    public function isSoldOut()
    {
        return $this->remainder <= 0;
    }    
}
