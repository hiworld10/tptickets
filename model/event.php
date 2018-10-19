<?php
namespace model;


/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:07
 */
class Event
{

	private $id;
	private $name;
	private $date;
    public $category;


	function __construct($name, $date)
	{
		$this->id =	null;
		$this->name = $name;
		$this->date = $date;
        $this->category= null;
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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
?>