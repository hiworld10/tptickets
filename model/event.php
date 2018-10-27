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
    private $category;


	function __construct($name, $category)
	{
		$this->id =	null;
		$this->name = $name;
        $this->category= $category;
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

     public function getCategory()
    {
        return $this->category->getType();
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }


}
?>