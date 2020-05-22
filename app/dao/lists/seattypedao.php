<?php 
namespace dao\lists;

use dao\IDAO as IDAO;


class SeatTypeDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["seatType"])) {
			$this->list = $_SESSION["seatType"];
		} 
		else {
			$this->list = array();
			$_SESSION["idseatType"] = 0;
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["seatType"])) {
			$this->list = $_SESSION["seatType"];
		} 
		$newVal->setId(++$_SESSION["idseatType"]);
		array_push($this->list, $newVal);

		$_SESSION["seatType"] = $this->list;

	}

	public function retrieveById($id) {
		if (isset($_SESSION["seatType"])) {
			$this->list = $_SESSION["seatType"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}


	public function retrieveAll() {
		if(isset($_SESSION['seatType'])) {
			$this->list = $_SESSION['seatType'];
			return $this->list;

		}
		return false;
	}
	


	public function update($newVal) {
		if(isset($_SESSION['seatType'])) {
			$this->list = $_SESSION['seatType'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value->setType($newVal->getType());
				}
			}
		}
		$_SESSION['seatType'] = $this->list;
	}

	public function delete($id) {

		if(isset($_SESSION['seatType']))
		{

			$list= $_SESSION['seatType'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['seatType']= $list;
			}
		}
	}

}
?>