<?php
namespace app\models;

use app\models\PurchaseLine as PurchaseLine;

class Purchase
{

	private $id;
    private $date;
    private $purchaseLine; //posible array???

	function __construct($id, $date, $purchaseLine)
	{
        $this->id = $id;
        $this->date = $date;
        $this->purchaseLine = $purchaseLine;
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

    public function getPurchaseLine()
    {
        return $this->purchaseLine;
    }

    public function setPurchaseLine($purchaseLine)
    {
        $this->purchaseLine = $purchaseLine;
    }
}
?>