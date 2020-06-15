<?php
namespace app\models;

use app\models\Ticket;

class PurchaseLine
{
    private $id;
	private $amount;
    private $ticket;
	private $purchase_id;

	function __construct($id, $amount, Ticket $ticket, $purchase_id)
	{
        $this->id = $id;
        $this->amount = $amount;
        $this->ticket = $ticket;
        $this->purchase_id = $purchase_id;
	}

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function getPurchaseId()
    {
        return $this->purchase_id;
    }
}
?>