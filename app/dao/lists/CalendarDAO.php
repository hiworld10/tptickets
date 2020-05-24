<?php 
namespace dao\lists;
use app\dao\IDAO as IDAO;
class CalendarDAO implements IDAO
{
	private $list;
	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["calendars"])) {
			$this->list = $_SESSION["calendars"];
		} 
		else {
			$this->list = array();
			$_SESSION["idcalendars"] = 0;
		}
	}
	public function create($newVal) {
		if (isset($_SESSION["calendars"])) {
			$this->list = $_SESSION["calendars"];
		} 
		$newVal->setId(++$_SESSION["idcalendars"]);
		array_push($this->list, $newVal);
		$_SESSION["calendars"] = $this->list;
	}
	public function retrieveById($id) {
		if (isset($_SESSION["calendars"])) {
			$this->list = $_SESSION["calendars"];
			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}
		return false;
	}
	public function retrieveAll() {
		if(isset($_SESSION['calendars'])) {
			$this->list = $_SESSION['calendars'];
			return $this->list;
		}
		return false;
	}
	
	public function update($newVal) {
		if(isset($_SESSION['calendars'])) {
			$this->list = $_SESSION['calendars'];
			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value->setDate($newVal->getDate());
					$value->setEvent($newVal->getEvent());
					$value->setArtistArray($newVal->getArtistArray());
					$value->setPlaceEvent($newVal->getPlaceEvent());
					$value->setSeatType($newVal->getSeatType());
				}
			}
		}
		$_SESSION['calendars'] = $this->list;
	}
	public function delete($newVal) {
		if(isset($_SESSION['calendars'])) {
			
			$list= $_SESSION['calendars'];
			foreach ($list as $key => $value) {
				if($newVal == $value->getId()) {
					unset($list[$key]);	
				}
				$_SESSION['calendars']= $list;
			}
		}
	}
}
?>