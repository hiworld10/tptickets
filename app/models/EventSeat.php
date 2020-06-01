<?php
namespace app\models;
use app\models\SeatType as SeatType;

class EventSeat
{
    private $id;
	private $calendarId;
    private $seatType;
    private $quantity;
    private $price;
    private $remainder;

	function __construct($id, $calendarId,SeatType $seatType, $quantity, $price, $remainder)
	{
        $this->id = $id;
        $this->calendarId = $calendarId;
        $this->seatType = $seatType;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->remainder = $remainder;
	}

    public function setQuantity($newQuantity)
    {
        $this->remainder = $newQuantity - $this->quantity + $this->$remainder;
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

    public function getSeatType()
    {
        return $this->seatType;
    }

    public function setSeatType($seatType)
    {
        $this->seatType = $seatType;
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

    public function getQuantity()
    {
        return $this->quantity;
    }
}
?>