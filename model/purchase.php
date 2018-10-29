<?php
namespace model;

//Necesita ser implementada
class Purchase
{

	private $id;

	function __construct()
	{
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
}
?>