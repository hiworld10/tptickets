<?php

namespace app\models;

use app\models\Event;
use app\models\EventSeat;
use app\models\PlaceEvent;

class Calendar
{
    private $id;
    private $date;
    private $event;
    private $artistArray;
    private $placeEvent;
    private $eventSeat;

    public function __construct($id, $date, Event $event, $artistArray, PlaceEvent $placeEvent, $eventSeat)
    {
        $this->id          = $id;
        $this->date        = $date;
        $this->event       = $event;
        $this->artistArray = $artistArray;
        $this->placeEvent  = $placeEvent;
        $this->eventSeat   = $eventSeat;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getArtistArray()
    {
        return $this->artistArray;
    }

    public function getPlaceEvent()
    {
        return $this->placeEvent;
    }

    public function getEventSeat()
    {
        return $this->eventSeat;
    }

    public function isSoldOut()
    {
        $sold_out = true;
        foreach ($this->getEventSeat() as $event_seat) {
            if ($event_seat->getRemainder() > 0) {
                return false;
            }
        }
        return true;
    }
}
