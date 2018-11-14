<?php 
namespace controllers;

use model\Ticket as Ticket;
use dao\lists\TicketDAO as List_TicketDAO;
use dao\db\TicketDAO as DB_TicketDAO;
use controllers\HomeController as HomeController;


class TicketController {

	private $dao;



	public function __construct() {
		$this->dao = new DB_TicketDAO();
	}


	public function addTicket($ticket) {

		try {
			$this->dao->create($ticket);
			$this->getAll();
			return true;
		} catch(\PDOException $ex) {
			throw $ex;
		}
	}

	/*
	public function getAll(){
		$ticketArray = $this->dao->retrieveAll();
		include ADMIN_VIEWS . '/';		//Falta la view de tickets
		
	}
	*/

	/*
	public function getTicket($id) {
		$ticket = $this->dao->retrieveById($id);
		if(isset($ticket)){
			include ADMIN_VIEWS . '/';	//Falta la view de tickets
		}
	}
	*/

	public function deleteTicket($id){

		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateTicket($id, $purchaselineid, $number, $qr) {
		$updateTicket = new M_Ticket($id, $amount, $newticket, $purchaseid);
		$this->dao->update($updateTicket);
		$this->getAll();
	}


	public function getTicketSelect($id) {
		return $this->dao->retrieveById($id);
	}
}

?>
