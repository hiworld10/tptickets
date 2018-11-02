<?php
namespace model;

use model\Ticket as Ticket;
use model\Purchase as Purchase;

class PurchaseLine
{

	private $amount;
	public $ticket;
	public $purchase;

	function __construct($amount, Ticket $ticket, Purchase $purchase)
	{
        $this->amount = $amount;
        $this->ticket = $ticket;
        $this->purchase = $purchase;
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

    public function getPurchase()
    {
        return $this->purchase;
    }

    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    }
}
?>