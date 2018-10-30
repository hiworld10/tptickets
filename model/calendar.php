<?php
namespace model;



class Calendar
{
    private $id;
	private $date;
    private $eventId;

	function __construct($id, $date, $eventId)
	{
        $this->id= $id;
        $this->date= $date;
        $this->eventId= $eventId;
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

    public function getEventId()
    {
        return $this->eventId;
    }

    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }
}
?>