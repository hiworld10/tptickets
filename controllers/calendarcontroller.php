<?php 
namespace controllers;
use model\Calendar as M_Calendar;
use dao\lists\CalendarDAO as List_CalendarDAO;
use dao\db\CalendarDAO as DB_CalendarDAO;
use controllers\EventController as EventController;
use controllers\ArtistController as ArtistController;
use controllers\PlaceEventController as PlaceEventController;
use controllers\SeatTypeController as SeatTypeController;


class CalendarController {

	private $dao;
	private $eventController;
	private $placeEventController;
	private $artistController;
	private $seatTypeController;

	public function __construct() {
		$this->dao = new DB_CalendarDAO();
		$this->eventController = new EventController();
		$this->placeEventController = new PlaceEventController();
		$this->artistController = new ArtistController();
		$this->seatTypeController = new SeatTypeController();
	}

	public function addCalendar($date, $id_event, $artistIdArray, $id_placeEvent, $id_seatType) {
		
		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$event=$this->eventController->getEventById($id_event);
			$seatType=$this->seatTypeController->getSeatTypeById($id_seatType);
			


			$placeEvent=$this->placeEventController->getPlaceEventById($id_placeEvent);

			$artists=array();
			foreach ($artistIdArray as $key => $value) {
				$artist=$this->artistController->getArtistById($value);
				array_push($artists, $artist);
			}
			$m_calendar = new M_Calendar(null, $date, $event, $artists, $placeEvent, $seatType);
			$this->dao->create($m_calendar);
			$this->getAll();

			
		}


	}

	public function getCalendar($id) { 
		$calendar=$this->dao->retrieveById($id);
		
		if(isset($calendar)) {
			include ADMIN_VIEWS . '/admincalendar.php';
		}
	}

	public function getAll() {
		$calendarArray = $this->dao->retrieveAll();
		$eventArray = $this->eventController->getAllSelect();
		$placeEventArray = $this->placeEventController->getAllSelect();
		$artistArray = $this->artistController->getAllSelect();
		$seatTypeArray = $this->seatTypeController->getAllSelect();




		include ADMIN_VIEWS. '/admincalendar.php';
	}

	public function deleteCalendar($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateCalendar($id, $date, $id_event, $artistIdArray, $id_placeEvent, $id_seatType) {

		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$event=$this->eventController->getEventById($id_event);
			$placeEvent=$this->placeEventController->getPlaceEventById($id_placeEvent);
			$seatType=$this->seatTypeController->getSeatTypeById($id_seatType);
			$artists=array();
			foreach ($artistIdArray as $key => $value) {
				$artist=$artistController->getArtistById($value);
				array_push($artists, $artist);
			}
			$updatedCalendar = new M_Calendar($id, $date, $event, $artistArray, $placeEvent, $seatType);
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