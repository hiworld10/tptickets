<?php
namespace model;

use model\Event as Event;
use model\PlaceEvent as PlaceEvent;
use model\SeatType as SeatType;


class Calendar
{
    private $id;
	private $date;
    private $event;
    private $artistArray;
    private $placeEvent;
    private $seatType;

	function __construct($id, $date, Event $event, $artistArray, PlaceEvent $placeEvent, SeatType $seatType)
	{
        $this->id= $id;
        $this->date= $date;
        $this->event= $event;
        $this->artistArray= $artistArray;
        $this->placeEvent= $placeEvent;
        $this->seatType= $seatType;
	}

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getArtistArray()
    {
        return $this->artistArray;
    }

    public function setArtistArray($artistArray)
    {
        $this->artistArray = $artistArray;
    }

    public function getPlaceEvent()
    {
        return $this->placeEvent;
    }

    public function setPlaceEvent($placeEvent)
    {
        $this->placeEvent = $placeEvent;
    }

    public function getSeatType()
    {
        return $this->seatType;
    }

    public function setSeatType($seatType)
    {
        $this->seatType = $seatType;
    }
}
?>