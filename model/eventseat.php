<?php
namespace model;


class EventSeat
{

	private $availableSeats;
	private $price;
	public $m_purchaseLine;

	function __construct($availableSeats, $price)
	{
        $this->availableSeats= $availableSeats;
        $this->price= $price;
        $this->m_purchaseLine=null;
	}

    public function getAvailableSeats()
    {
        return $this->availableSeats;
    }

    public function setAvailableSeats($availableSeats)
    {
        $this->availableSeats = $availableSeats;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getMPurchaseLine()
    {
        return $this->m_purchaseLine;
    }

    public function setMPurchaseLine($m_purchaseLine)
    {
        $this->m_purchaseLine = $m_purchaseLine;

        return $this;
    }
}
?>