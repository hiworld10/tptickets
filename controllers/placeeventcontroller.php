<?php 
namespace controllers;

use model\PlaceEvent as M_PlaceEvent;
use dao\lists\PlaceEventDAO as List_PlaceEventDAO;
use dao\db\PlaceEventDAO as DB_PlaceEventDAO;


class PlaceEventController {

	private $dao;

	public function __construct() {
		$this->dao = new DB_PlaceEventDAO();
	}

	public function addPlaceEvent($capacity, $description) {

		$m_placeEvent = new M_PlaceEvent(null, 1, $capacity, $description);
		$this->dao->create($m_placeEvent);
		$this->getAll();
	}

	public function getAll() {
		$placeEventArray = $this->dao->retrieveAll(); 
		include ADMIN_VIEWS . '/adminplaceevent.php';
	}

	public function getAllSelect() {
		return $this->dao->retrieveAll();
	}
	

	public function deletePlaceEvent($id) {

		$this->dao->delete($id);
		$this->getAll();
	}


	public function getPlaceEvent($id) {
		$placeEvent=$this->dao->retrieveById($id);		
		if(isset($placeEvent)) {
			include ADMIN_VIEWS . '/adminplaceevent.php';
		}
	}

	public function getPlaceEventSelect($id) {
		return $this->dao->retrieveById($id);
	}


	public function updatePlaceEvent($id, $capacity, $description) {
		$updatedPlaceEvent = new M_PlaceEvent($id, null, $capacity, $description);
		$this->dao->update($updatedPlaceEvent);
		$this->getAll();
	}
}
?>
