<?php 
namespace controllers;
 use model\PurchaseLine;
use dao\lists\PurchaseLineDAO as List_PurchaseLineDAO;
use dao\db\PurchaseLineDAO as DB_PurchaseLineDAO;
use controllers\TicketController;
use controllers\HomeController;
 class PurchaseLineController {
 	private $dao;
 	private $ticketController;
	private $purchaseController;
 	public function __construct() {
		$this->dao = new DB_PurchaseLineDAO();
	}
 	public function addPurchaseLine($purchaseLine) {
 		try {
			$this->dao->create($purchaseLine);
			$this->getAll();
			return true;
		} catch(\PDOException $ex) {
			throw $ex;
		}
	}
 	public function getAll(){
		$purchaseLineArray = $this->dao->retrieveAll();
		require ADMIN_VIEWS . '/adminpurchase.php';
		
	}
 	public function getPurchaseLine($id) {
		$purchase = $this->dao->retrieveById($id);
		if(isset($purchaseLine)){
			require ADMIN_VIEWS . '/adminpurchase.php';
		}
	}
 	public function deletePurchaseLine($id){
 		$this->dao->delete($id);
		$this->getAll();
	}
 	public function updatePurchaseLine($id, $amount, $ticketid, $purchaseid) {
 		$newTicket = $this->ticketcontroller->getTicketSelect($ticketid);
		$updatedPurchaseLine = new PurchaseLine($id, $amount, $newticket, $purchaseid);
		$this->dao->update($updatedPurchaseLine);
		$this->getAll();
	}
}
 ?>