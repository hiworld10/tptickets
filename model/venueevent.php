<?php
namespace model;

//Necesita ser implementada
class VenueEvent
{

	private $address;
	private $id;
	private $location;
	private $name;
	public $m_placeType;

	function __construct()
	{
	}


    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getMPlaceType()
    {
        return $this->m_placeType;
    }

    public function setMPlaceType($m_placeType)
    {
        $this->m_placeType = $m_placeType;

        return $this;
    }
}
?>