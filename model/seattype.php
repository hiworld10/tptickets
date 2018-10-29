<?php
namespace model;






/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:07
 */
class SeatType
{

	private $id;
	private $name;
	public $m_eventSeat;

	function __construct($name)
	{
        $this->id= null;
        $this->name= $name;
        $this->m_eventSeat= null;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getMEventSeat()
    {
        return $this->m_eventSeat;
    }

    public function setMEventSeat($m_eventSeat)
    {
        $this->m_eventSeat = $m_eventSeat;

        return $this;
    }
}
?>