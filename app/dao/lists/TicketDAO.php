<?php 
namespace dao\lists;


class TicketDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_SESSION["tickets"])) {
			$this->list = $_SESSION["tickets"];
		} 
		else {
			$this->list = array();
			$_SESSION["tickets"] = 0;
		}
	}

	public function create($newVal) {
		if (isset($_SESSION["tickets"])) {
			$this->list = $_SESSION["tickets"];
		} 
		$newVal->setId(++$_SESSION["idticket"]);
		array_push($this->list, $newVal);

		$_SESSION["tickets"] = $this->list;
	}

	public function retrieveById($id) {
		if (isset($_SESSION["tickets"])) {
			$this->list = $_SESSION["tickets"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['tickets'])) {
			$this->list = $_SESSION['tickets'];

			return $this->list;

		}
		return false;
	}

	public function update($newVal){
		if(isset($_SESSION['tickets'])) {
			$this->list = $_SESSION['tickets'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value = $newVal();
				}
			}
		}
		$_SESSION['tickets'] = $this->list;
	}

	public function delete($id) {


		if(isset($_SESSION['tickets']))
		{

			$list= $_SESSION['tickets'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['tickets']= $list;
			}
		}
	}

}
?>