<?php
namespace model;

class PlaceEvent
{
	private $id;
	private $idCalendar;
	private $capacity;
	private $description;

	function __construct($id, $idCalendar, $capacity, $description)
	{
		$this->id = $id;
		$this->idCalendar = $idCalendar;
		$this->capacity = $capacity;
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

	
	public function setId($id)
	{
		$this->id = $id;
	}


	public function setIdCalendar($idCalendar)
	{
		$this->idCalendar = $idCalendar;
	}

	public function setCapacity($capacity)
	{
		$this->capacity = $capacity;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}


}
?>