<?php
namespace model;


class EventSeat
{
    private $id;
	private $calendarId;
    private $seatTypeId;
    private $quantity;
    private $price;
    private $remainder;

	function __construct($id, $calendarId, $seatTypeId, $quantity, $price)
	{
        $this->id = $id;
        $this->calendarId = $calendarId;
        $this->seatTypeId = $seatTypeId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->remainder = $quantity;
	}

    public function getQuantity()
    {
        return $this->$quantity;
    }

    public function setQuantity($newQuantity)
    {
        $this->remainder = $newQuantity - $this->quantity + $remainder;
        $this->quantity = $newQuantity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCalendarId()
    {
        return $this->calendarId;
    }

    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;
    }

    public function getSeatTypeId()
    {
        return $this->seatTypeId;
    }

    public function setSeatTypeId($seatTypeId)
    {
        $this->seatTypeId = $seatTypeId;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getRemainder()
    {
        return $this->remainder;
    }
}
?>