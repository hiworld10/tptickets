<?php
namespace model;

//Banda????
class Band
{

	private $id;
	private $name;
	public $m_calendar;

	function __construct($id, $name)
	{
        $this->id= null;
        $this->name= $name;
        $this->m_calendar= null;
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

    public function getMCalendar()
    {
        return $this->m_calendar;
    }

    public function setMCalendar($m_calendar)
    {
        $this->m_calendar = $m_calendar;

        return $this;
    }
}
?>