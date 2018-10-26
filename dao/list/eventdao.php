<?php 
namespace dao\list;


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

	//PARAMETROS ???
	public function retrieve() {
		if(isset($_SESSION['events'])) {
			$this->list = $_SESSION['events'];
			/*echo "<pre>";
			var_dump($this->list);
			echo "</pre>";*/
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