<?php
namespace model;


class EventSeat
{
    private $id;
	private $availableSeats;
	private $price;
	private $calendarId;
    private $seatTypeId;

	function __construct($id, $availableSeats, $price, $calendarId, $seatTypeId)
	{
        $this->id= $id;
        $this->availableSeats= $availableSeats;
        $this->price= $price;
        $this->calendarId= $calendarId;
        $this->seatTypeId= $seatTypeId;
	}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailableSeats()
    {
        return $this->$availableSeats;
    }

    public function setAvailableSeats($availableSeats)
    {
        $this->availableSeats = $availableSeats;

    }
    public function getCalendarId()
    {
        return $this->$calendarId;
    }

    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;
    }
     public function getSeatTypeId()
    {
        return $this->$seatTypeId;
    }

    public function setSeatTypeId($seatTypeId)
    {
        $this->seatTypeId = $seatTypeId;
    }
}
?>