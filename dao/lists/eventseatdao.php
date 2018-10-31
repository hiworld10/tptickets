<?php 
namespace dao\lists;
use dao\IDAO as IDAO;
class EventSeatDAO implements IDAO
{
	private $list;
	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["eventsseat"])) {
			$this->list = $_SESSION["eventsseat"];
		} 
		else {
			$this->list = array();
			$_SESSION["ideventseat"] = 0;
		}
	}
	public function create($newVal) {
		if (isset($_SESSION["eventsseat"])) {
			$this->list = $_SESSION["eventsseat"];
		} 
		$newVal->setId(++$_SESSION["ideventseat"]);
		array_push($this->list, $newVal);
		$_SESSION["eventsseat"] = $this->list;
	}
	public function retrieveById($id) {
		if (isset($_SESSION["eventsseat"])) {
			$this->list = $_SESSION["eventsseat"];
			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}
		return false;
	}
	public function retrieveAll() {
		if(isset($_SESSION['eventsseat'])) {
			$this->list = $_SESSION['eventsseat'];
			return $this->list;
		}
		return false;
	}
	
	public function update($newVal) {
		if(isset($_SESSION['eventsseat'])) {
			$this->list = $_SESSION['eventsseat'];
			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value->setAvailableSeats($newVal->getAvailableSeats());
					$value->setPrice($newVal->getPrice());
					$value->setCalendarId($newVal->getCalendarId());
					$value->setSeatTypeId($newVal->getSeatTypeId());
				}
			}
		}
		$_SESSION['eventsseat'] = $this->list;
	}
	public function delete($newVal) {
		if(isset($_SESSION['eventsseat'])) {
			
			$list= $_SESSION['eventsseat'];
			foreach ($list as $key => $value) {
				if($newVal == $value->getId()) {
					unset($list[$key]);	
				}
				$_SESSION['eventsseat']= $list;
			}
		}
	}
}
?>