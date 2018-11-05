<?php 
namespace dao\lists;


class PurchaseDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_SESSION["purchase"])) {
			$this->list = $_SESSION["purchase"];
		} 
		else {
			$this->list = array();
			$_SESSION["purchase"] = 0;
		}
	}

	public function create($newVal) {
		if (isset($_SESSION["purchase"])) {
			$this->list = $_SESSION["purchase"];
		} 
		$newVal->setId(++$_SESSION["idpurchase"]);
		array_push($this->list, $newVal);

		$_SESSION["purchase"] = $this->list;
	}

	public function retrieveById($id) {
		if (isset($_SESSION["purchase"])) {
			$this->list = $_SESSION["purchase"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['purchase'])) {
			$this->list = $_SESSION['purchase'];

			return $this->list;

		}
		return false;
	}

	public function update($newVal){
		if(isset($_SESSION['purchase'])) {
			$this->list = $_SESSION['purchase'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value = $newVal();
				}
			}
		}
		$_SESSION['purchase'] = $this->list;
	}

	public function delete($id) {


		if(isset($_SESSION['purchase']))
		{

			$list= $_SESSION['purchase'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['purchase']= $list;
			}
		}
	}

}
?>