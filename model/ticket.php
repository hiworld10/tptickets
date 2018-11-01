<?php
namespace model;




/**
 * @author alumno
 * @version 1.0
 * @created 26-sep.-2018 13:28:08
 */
class Ticket
{
	private $id_ticket;
	private $id_purchase_line;
	private $number;
	private $qr;
	

	function __construct($id_ticket, $id_purchase_line, $number, $qr)
	{
		$this->id_ticket = $id_ticket;
		$this->id_purchase_line = $id_purchase_line;
		$this->number = $number;
		$this->qr = $qr;
		
	}


	public function getIdTicket()
	{
		return $this->id_ticket;
	}

	public function getIdPurchaseLine()
	{
		return $this->id_purchase_line;
	}

	public function getNumber()
	{
		return $this->number;
	}

	public function getQr()
	{
		return $this->qr;
	}


	
	public function setIdTicket($id_ticket)
	{
		$this->id_ticket=$id_ticket;
	}


	public function setIdPurchaseLine($id_purchase_line)
	{
		$this->id_purchase_line=$id_purchase_line;
	}

	public function setNumber($number)
	{
		$this->number=$number;
	}

	public function setQr($qr)
	{
		$this->qr=$qr;
	}


}
?>