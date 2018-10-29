<?php
namespace model;

//Necesita ser implementada
class PurchaseLine
{

	private $amount;
	public $m_ticket;
	public $m_purchase;

	function __construct()
	{
	}


    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMTicket()
    {
        return $this->m_ticket;
    }

    public function setMTicket($m_ticket)
    {
        $this->m_ticket = $m_ticket;

        return $this;
    }

    public function getMPurchase()
    {
        return $this->m_purchase;
    }

    public function setMPurchase($m_purchase)
    {
        $this->m_purchase = $m_purchase;

        return $this;
    }
}
?>