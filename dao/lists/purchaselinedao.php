<?php 
namespace dao\lists;


class PurchaseLineDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_SESSION["purchaseline"])) {
			$this->list = $_SESSION["purchaseline"];
		} 
		else {
			$this->list = array();
			$_SESSION["purchaseline"] = 0;
		}
	}

	public function create($newVal) {
		if (isset($_SESSION["purchaseline"])) {
			$this->list = $_SESSION["purchaseline"];
		} 
		$newVal->setId(++$_SESSION["idpurchaseline"]);
		array_push($this->list, $newVal);

		$_SESSION["purchaseline"] = $this->list;
	}

	public function retrieveById($id) {
		if (isset($_SESSION["purchaseline"])) {
			$this->list = $_SESSION["purchaseline"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['purchaseline'])) {
			$this->list = $_SESSION['purchaseline'];

			return $this->list;

		}
		return false;
	}

	public function update($newVal){
		if(isset($_SESSION['purchaseline'])) {
			$this->list = $_SESSION['purchaseline'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value = $newVal();
				}
			}
		}
		$_SESSION['purchaseline'] = $this->list;
	}

	public function delete($id) {


		if(isset($_SESSION['purchaseline']))
		{

			$list= $_SESSION['purchaseline'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['purchaseline']= $list;
			}
		}
	}

}
?>