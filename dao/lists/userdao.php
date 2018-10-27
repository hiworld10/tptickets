<?php 
namespace dao\lists;

use dao\IDAO as IDAO;

class UserDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["users"])) {
			$this->list = $_SESSION["users"];
			
		} 
		else {
			$this->list = array();
			$_SESSION["iduser"] = 0;
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["users"])) {
			$this->list = $_SESSION["users"];

		} 
		$newVal->setId(++$_SESSION["iduser"]);
		array_push($this->list, $newVal);

		$_SESSION["users"] = $this->list;

	}

	public function retrieveById($id) {
		if (isset($_SESSION["users"])) {
			$this->list = $_SESSION["users"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['users'])) {
			$this->list = $_SESSION['users'];

			return $this->list;

		}
		return false;
	}
	

	public function update($newVal) {
		if(isset($_SESSION['users'])) {
			$this->list = $_SESSION['users'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value = $newVal;
				}
			}
		}
		$_SESSION['users'] = $this->list;
	}
	

	public function delete($id){

		if(isset($_SESSION['users'])) {

			$list= $_SESSION['users'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);
				}

				$_SESSION['users'] = $list;
			}	
		}
	}

		public function checkEmail($email) {
		$check=true;
		if (isset($_SESSION["users"])) {
			$this->list = $_SESSION["users"];

			foreach ($this->list as $key => $value) {
				if ($email == $value->getEmail()) {
					return false;
				}
			}
		}
		return $check;
		
	}

	public function checkPassword($pass){

	//strlen cuenta la cantidad de caracteres String
	//en este caso vamos a restringir la pass a mas de 6 caracteres 
		if(strlen ($pass) < 6){
			return false;
		}

		return true;
	}
}
?>