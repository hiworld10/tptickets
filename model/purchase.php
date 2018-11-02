<?php
namespace model;

use model\PurchaseLine as PurchaseLine;

class Purchase
{

	private $id;
    private $date;
    private $purchaseLine; //array???

	function __construct($id, $date)
	{
        $this->id = $id;
        $this->date = $date;
	}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}
?>