<?php 

namespace app\controllers;

use app\models\Purchase;
use app\dao\lists\PurchaseDAO as List_PurchaseDAO;
use app\dao\db\PurchaseDAO as DB_PurchaseDAO;
use app\controllers\Home;


class Purchases {

	private $dao;

	public function __construct() {
		$this->dao = new  DB_PurchaseDAO();
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
		require ADMIN_VIEWS . '/adminpurchase.php';
	}

	public function getPurchase($id) {
		$purchase = $this->dao->retrieveById($id);
		if(isset($purchase)){
			require ADMIN_VIEWS . '/adminpurchase.php';
		}
	}

	public function deletePurchase($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updatePurchase($id, $date, $purchaseline) {
		$updatedPurchase = new Purchase($id, $date, $purchaseline);
		$this->dao->update($updatedPurchase);
		$this->getAll();
	}
}

?>
