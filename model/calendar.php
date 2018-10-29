<?php
namespace model;



class Calendar
{
    private $id
	private $date;
	private $m_event;
	private $m_eventSeat;
    private $m_artist;
    private $m_eventVenue;

	function __construct($date)
	{
        $this->id= null;
        $this->date= $date;
        $this->m_event= null;
        $this->m_eventSeat= null;
        $this->m_artist= null;
        $this->m_eventVenue= null;


	}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getMEvent()
    {
        return $this->m_event;
    }

    public function setMEvent($m_event)
    {
        $this->m_event = $m_event;

        return $this;
    }

    public function getMEventPlace()
    {
        return $this->m_eventPlace;
    }

    public function setMEventPlace($m_eventPlace)
    {
        $this->m_eventPlace = $m_eventPlace;

        return $this;
    }
}
?>