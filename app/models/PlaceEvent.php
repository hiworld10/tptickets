<?php

namespace app\models;

class PlaceEvent
{
    private $id;
    private $idCalendar;
    private $capacity;
    private $description;

    public function __construct($id, $idCalendar, $capacity, $description)
    {
        $this->id          = $id;
        $this->idCalendar  = $idCalendar;
        $this->capacity    = $capacity;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCalendarId()
    {
        return $this->idCalendar;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
