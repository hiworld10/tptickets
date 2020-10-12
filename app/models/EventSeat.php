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

    /**
     * Devuelve true o false dependiendo de si el tipo de asiento de evento dispone de 
     * suficientes asientos para efectuar una compra.
     * @param  int  $amount la cantidad de asientos a comprar
     * @return boolean
     */
    public function hasAvailable($amount)
    {
        return $this->remainder >= $amount;
    }

    /**
     * Determina si el de tipo de asiento de evento está vendido en su totalidad.
     * @return boolean
     */
    public function isSoldOut()
    {
        return $this->remainder <= 0;
    }    
}
