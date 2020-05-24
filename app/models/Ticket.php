<?php
namespace app\models;

class Ticket
{
	private $id;
	private $purchaseLineId;
	private $number;
	private $qr;
	

	function __construct($id, $purchaseLineId, $number, $qr)
	{
		$this->id = $id;
		$this->purchaseLineId = $purchaseLineId;
		$this->number = $number;
		$this->qr = $qr;
	}


	public function getId()
	{
		return $this->id;
	}

	public function getPurchaseLineId()
	{
		return $this->purchaseLineId;
	}

	public function getNumber()
	{
		return $this->number;
	}

	public function getQr()
	{
		return $this->qr;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setPurchaseLineId($purchaseLineId)
	{
		$this->purchaseLineId = $purchaseLineId;
	}

	public function setNumber($number)
	{
		$this->number = $number;
	}

	public function setQr($qr)
	{
		$this->qr = $qr;
	}
}
?>