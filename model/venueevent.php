<?php
namespace model;
require_once ('Tipo_Plaza.php');




use ;
/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:07
 */
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