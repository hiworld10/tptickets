<?php 
namespace dao;


class CategoryDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["categorys"])) {
			$this->list = $_SESSION["categorys"];
		} 
		else {
			$this->list = array();
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["categorys"])) {
			$this->list = $_SESSION["categorys"];
		} 

		array_push($this->list, $newVal);

		$_SESSION["categorys"] = $this->list;

	}

	public function getById($id) {
		if (isset($_SESSION["categorys"])) {
			$this->list = $_SESSION["categorys"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}


	public function retrieve() {
		if(isset($_SESSION['categorys'])) {
			$this->list = $_SESSION['categorys'];
			return $this->list;

		}
		return false;
	}
	


public function update($newVal) {

}

public function delete($newVal) {

}




}
?>