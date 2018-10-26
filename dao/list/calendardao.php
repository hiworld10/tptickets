<?php 
namespace dao\list;


class CalendarDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["calendar"])) {
			$this->list = $_SESSION["calendar"];
		} 
		else {
			$this->list = array();
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["calendar"])) {
			$this->list = $_SESSION["calendar"];
		} 

		array_push($this->list, $newVal);

		$_SESSION["calendar"] = $this->list;

	}

	public function getByDate($date) {
		if (isset($_SESSION["calendar"])) {
			$this->list = $_SESSION["calendar"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getDate()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveById($id) {
		
	}

	public function retrieveAll() {
		if(isset($_SESSION['calendar'])) {
			$this->list = $_SESSION['calendar'];
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