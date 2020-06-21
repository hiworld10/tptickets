<?php
namespace app\models;

use app\models\Category;

class Event
{

	private $id;
	private $name;
	//No se debe explicitar el tipo de clase dentro del atributo propio
    private $category;
    private $image;


	function __construct($id, $name, Category $category, $image) //Si en los parametros
	{
		$this->id =	$id;
		$this->name = $name;
        $this->category = $category;
        $this->image = $image;
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}
?>
