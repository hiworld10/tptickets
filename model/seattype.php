<?php
namespace model;

class SeatType
{

	private $id;
	private $type;

	function __construct($id, $name)
	{
        $this->id = $id;
        $this->type = $type;
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
        return $this->type;
    }

    public function setName($type)
    {
        $this->type = $type;
    }
}
?>