<?php
namespace model;

use model\Ticket as Ticket;

class PurchaseLine
{

    private $id;
	private $amount;
    private $ticket;
	private $purchaseId;
	

	function __construct($id, $amount, Ticket $ticket, $purchaseId)
	{
        $this->id = $id;
        $this->amount = $amount;
        $this->ticket = $ticket;
        $this->purchaseId = $purchaseId;
	}


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function getPurchaseId()
    {
        return $this->purchaseId;
    }

    public function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;
    }
}
?>