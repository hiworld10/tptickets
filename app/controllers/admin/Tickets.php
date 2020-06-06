<?php 

namespace app\controllers;

use app\models\Ticket;
use app\dao\lists\TicketDAO as List_TicketDAO;
use app\dao\db\TicketDAO as DB_TicketDAO;
use app\controllers\Home;

class Tickets {

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
		require ADMIN_VIEWS . '/';		//Falta la view de tickets
		
	}
	*/
 	/*
	public function getTicket($id) {
		$ticket = $this->dao->retrieveById($id);
		if(isset($ticket)){
			require ADMIN_VIEWS . '/';	//Falta la view de tickets
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