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
    public $category;


	function __construct($name)
	{
		$this->id =	null;
		$this->name = $name;
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


}
?>