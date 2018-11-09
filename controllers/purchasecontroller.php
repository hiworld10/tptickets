<?php 
namespace controllers;

use model\Purchase as M_Purchase;
use dao\lists\PurchaseDAO as List_PurchaseDAO;
use dao\db\PurchaseDAO as DB_PurchaseDAO;
use controllers\HomeController as HomeController;


class PurchaseController {

	private $dao;


	public function __construct() {
		$this->dao = new DB_PurchaseDAO();
	}


	public function addPurchase($purchase) {

		try {
			$this->dao->create($purchase);
			$this->getAll();
			return true;
		} catch(\PDOException $ex) {
			throw $ex;
		}
	}

	public function getAll(){
		$purchaseArray = $this->dao->retrieveAll();
		include ADMIN_VIEWS . '/adminpurchase.php';
		
	}

	public function getPurchase($id) {
		$purchase = $this->dao->retrieveById($id);
		if(isset($purchase)){
			include ADMIN_VIEWS . '/adminpurchase.php';
		}
	}

	public function deletePurchase($id){

		$this->dao->delete($id);
		$this->getAll();
	}

	public function updatePurchase($id, $date, $purchaseline) {

		$updatedPurchase = new M_Purchase($id, $date, $purchaseline);
		$this->dao->update($updatedPurchase);
		$this->getAll();
	}
}

?>
