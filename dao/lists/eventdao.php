<?php 
namespace dao\lists;

use dao\IDAO as IDAO;

class EventDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["events"])) {
			$this->list = $_SESSION["events"];
		} 
		else {
			$this->list = array();
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["events"])) {
			$this->list = $_SESSION["events"];
		} 

		array_push($this->list, $newVal);

		$_SESSION["events"] = $this->list;

	}

	public function getById($id) {
		if (isset($_SESSION["events"])) {
			$this->list = $_SESSION["events"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['events'])) {
			$this->list = $_SESSION['events'];

			return $this->list;

		}
		return false;
	}
	
	public function update($newVal) {
		if(isset($_SESSION['events'])) {
			$this->list = $_SESSION['events'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value->setName($newVal->getName());
					$value->setCategory($newVal->getCategory());
				}
			}
		}
		$_SESSION['events'] = $this->list
	}

	public function delete($newVal) {
		if(isset($_SESSION['events'])) {
			
			$list= $_SESSION['events'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()) {
					unset($list[$key]);	
				}
				$_SESSION['events']= $list;
			}
		}
	}




}
?>