<?php
namespace model;

use model\Event as Event;
use model\PlaceEvent as PlaceEvent;
use model\EventSeat as EventSeat;


class Calendar
{
    private $id;
	private $date;
    private $event;
    private $artistArray;
    private $placeEvent;
    private $eventSeat;

	function __construct($id, $date, Event $event, $artistArray, PlaceEvent $placeEvent, EventSeat $eventSeat)
	{
        $this->id = $id;
        $this->date = $date;
        $this->event = $event;
        $this->artistArray = $artistArray;
        $this->placeEvent = $placeEvent;
        $this->eventSeat = $eventSeat;
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

    public function getEventSeat()
    {
        return $this->eventSeat;
    }

    public function setEventSeat($eventSeat)
    {
        $this->eventSeat = $eventSeat;
    }
}
?>