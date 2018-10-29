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

	function __construct($id, $date, $m_event, $m_eventSeat, $m_artist, $m_eventVenue)
	{
        $this->id= $id;
        $this->date= $date;
        $this->m_event= $m_event;
        $this->m_eventSeat= $m_eventSeat;
        $this->m_artist= $m_artist;
        $this->m_eventVenue= $m_eventVenue;
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
    }

    public function getMEvent()
    {
        return $this->m_event;
    }

    public function setMEvent($m_event)
    {
        $this->m_event = $m_event;
    }

    public function getMEventSeat()
    {
        return $this->m_eventSeat;
    }

    public function setMEventSeat($m_eventSeat)
    {
        $this->m_eventSeat = $m_eventSeat;
    }

    public function getMArtist()
    {
        return $this->m_artist;
    }

    public function setMArtist($m_artist)
    {
        $this->m_artist = $m_artist;
    }

    public function getMEventVenue()
    {
        return $this->m_eventVenue;
    }

    public function setMEventVenue($m_eventVenue)
    {
        $this->m_eventVenue = $m_eventVenue;
    }
}
?>