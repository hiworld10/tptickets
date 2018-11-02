<?php
namespace model;

class PlaceEvent
{
	private $id;
	private $id_calendar;
	private $capacity;
	private $description;

	function __construct($id, $id_calendar, $capacity, $description)
	{
		$this->id = $id;
		$this->id_calendar = $id_calendar;
		$this->capacity = $capacity;
		$this->description = $description;
	}


	public function getId()
	{
		return $this->id;
	}

	public function getCalendarId()
	{
		return $this->id_calendar;
	}

	public function getCapacity()
	{
		return $this->capacity;
	}

	public function getDescription()
	{
		return $this->description;
	}

	
	public function setId($id)
	{
		$this->id=$id;
	}


	public function setIdCalendar($id_calendar)
	{
		$this->id_calendar=$id_calendar;
	}

	public function setCapacity($capacity)
	{
		$this->capacity=$capacity;
	}

	public function setDescription($description)
	{
		$this->description=$description;
	}


}
?>