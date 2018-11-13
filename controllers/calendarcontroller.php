<?php 
namespace controllers;
use model\Calendar as M_Calendar;
use dao\lists\CalendarDAO as List_CalendarDAO;
use dao\db\CalendarDAO as DB_CalendarDAO;
use controllers\EventController as EventController;
use controllers\ArtistController as ArtistController;
use controllers\PlaceEventController as PlaceEventController;

class CalendarController {

	private $dao;
	private $eventController;
	private $placeEventController;
	private $ArtistController;

	public function __construct() {
		$this->dao = new DB_CalendarDAO();
		$this->eventController = new EventController();
		$this->placeEventController = new PlaceEventController();
		$this->artistController = new ArtistController();
	}

	public function addCalendar($date, $id_event, $artistArray, $id_placeEvent) {
		
		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$event=$this->eventController->getEventById($id_event);
			$placeEvent=$this->placeEventController->getPlaceEventById($id_placeEvent);
			$m_calendar = new M_Calendar(null, $date, $event, $artistArray, $placeEvent);
			$this->dao->create($m_calendar);
			$this->getAll();

			
		}


	}

	public function getCalendar($id) { 
		$calendar=$this->dao->retrieveById($id);
		$eventArray = $this->eventController->getAllSelect();	
		$placeEventArray = $this->placeEventController->getAllSelect();
		$artistArray = $this->artistController->getAllSelect();
		if(isset($calendar) && isset($eventArray) && isset($placeEventArray) && isset($artistArray)) {
			include ADMIN_VIEWS . '/admincalendar.php';
		}
	}

	public function getAll() {
		$calendarArray = $this->dao->retrieveAll();
		$eventArray = $this->eventController->getAllSelect();
		$placeEventArray = $this->placeEventController->getAllSelect();
		$artistArray = $this->artistController->getAllSelect();




		include ADMIN_VIEWS. '/admincalendar.php';
	}

	public function deleteCalendar($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateCalendar($id, $date, $id_event, $artistArray, $id_placeEvent) {

		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$event=$this->eventController->getEventById($id_event);
			$placeEvent=$this->placeEventController->getPlaceEventById($id_placeEvent);
			$updatedCalendar = new M_Calendar($id, $date, $event, $artistArray, $placeEvent);
			$this->dao->update($updatedCalendar);
			$this->getAll();
		}
	}

	public function getAllSelect(){
		return $this->dao->retrieveAll();
	}

	/*Comprueba que la fecha introducida no sea pasada a la actual*/
	public function isBeforeNow($date) {
		return (strtotime($date) < strtotime('now'));
	}
	
}
?>