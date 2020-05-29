<?php 

namespace app\controllers;

use app\models\PlaceEvent;
use app\dao\lists\PlaceEventDAO as List_PlaceEventDAO;
use app\dao\db\PlaceEventDAO as DB_PlaceEventDAO;


class PlaceEvents extends \app\controllers\Authentication {

	private $dao;

	public function __construct() {
        $this->requireAdminLogin();
		$this->dao = new DB_PlaceEventDAO();
	}

	public function addPlaceEvent($calendarId, $capacity, $description ) {

		$placeEvent = new PlaceEvent(null, $calendarId, $capacity, $description);
		$this->dao->create($placeEvent);
	}

	public function addPlaceEventAndView($calendarId, $capacity, $description ) {

		$placeEvent = new PlaceEvent(null, $calendarId, $capacity, $description);
		$this->dao->create($placeEvent);
		$this->getAll();
	}


	public function index() {
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
		$updatedPlaceEvent = new PlaceEvent($id, $calendarId, $capacity, $description);
		$this->dao->update($updatedPlaceEvent);
	
	}
}
?>
