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

	public function addPlaceEvent($calendarId, $capacity, $description ) {

		$m_placeEvent = new M_PlaceEvent(null, $calendarId, $capacity, $description);
		$this->dao->create($m_placeEvent);
	}

	public function addPlaceEventAndView($calendarId, $capacity, $description ) {

		$m_placeEvent = new M_PlaceEvent(null, $calendarId, $capacity, $description);
		$this->dao->create($m_placeEvent);
		$this->getAll();
	}


	public function getAll() {
		$placeEventArray = $this->dao->retrieveAll(); 
		require ADMIN_VIEWS . '/adminplaceevent.php';
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
			require ADMIN_VIEWS . '/adminplaceevent.php';
		}
	}
	public function getPlaceEventById($id) {
		return $this->dao->retrieveById($id);		
		
	}

	public function getPlaceEventSelect($id) {
		return $this->dao->retrieveById($id);
	}


	public function updatePlaceEvent($id,$calendarId, $capacity, $description) {
		$updatedPlaceEvent = new M_PlaceEvent($id, $calendarId, $capacity, $description);
		$this->dao->update($updatedPlaceEvent);
	
	}
}
?>
