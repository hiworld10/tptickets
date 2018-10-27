<?php
namespace model;

class Event
{

	private $id;
	private $name;
    private $category;


	function __construct($name, $category)
	{
		$this->id =	null;
		$this->name = $name;
        $this->category = $category;
	}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}
?>