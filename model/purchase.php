<?php
namespace model;




/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:08
 */
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