<?php
namespace model;

use model\Category as Category;

class Event
{

	private $id;
	private $name;
    private Category $category;


	function __construct($id, $name, Category $category)
	{
		$this->id =	$id;
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

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }


}
?>