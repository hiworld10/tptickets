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
	private $type;
	

	function __construct($id,$type)
	{
        $this->id= $id;
        $this->type= $type;
     
	}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

    }

}
?>