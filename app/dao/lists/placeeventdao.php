<?php 
namespace dao\lists;


class PlaceEventDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_SESSION["placeevents"])) {
			$this->list = $_SESSION["placeevents"];
		} 
		else {
			$this->list = array();
			$_SESSION["placeevents"] = 0;
		}
	}

	public function create($newVal) {
		if (isset($_SESSION["placeevents"])) {
			$this->list = $_SESSION["placeevents"];
		} 
		$newVal->setId(++$_SESSION["idplaceevents"]);
		array_push($this->list, $newVal);

		$_SESSION["placeevents"] = $this->list;
	}

	public function retrieveById($id) {
		if (isset($_SESSION["placeevents"])) {
			$this->list = $_SESSION["placeevents"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['placeevents'])) {
			$this->list = $_SESSION['placeevents'];

			return $this->list;

		}
		return false;
	}

	public function update($newVal){
		if(isset($_SESSION['placeevents'])) {
			$this->list = $_SESSION['placeevents'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value = $newVal();
				}
			}
		}
		$_SESSION['placeevents'] = $this->list;
	}

	public function delete($id) {


		if(isset($_SESSION['placeevents']))
		{

			$list= $_SESSION['placeevents'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['placeevents']= $list;
			}
		}
	}

}
?>