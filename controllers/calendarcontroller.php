<?php 
namespace controllers;
use model\Calendar as M_Calendar;
use model\EventSeat as M_EventSeat;
use dao\lists\CalendarDAO as List_CalendarDAO;
use dao\db\CalendarDAO as DB_CalendarDAO;
use controllers\EventController as EventController;
use controllers\ArtistController as ArtistController;
use controllers\PlaceEventController as PlaceEventController;
use controllers\SeatTypeController as SeatTypeController;
use controllers\EventSeatController as EventSeatController;


class CalendarController {

	private $dao;
	private $eventController;
	private $placeEventController;
	private $artistController;
	private $seatTypeController;
	private $eventSeatController;

	public function __construct() {
		$this->dao = DB_CalendarDAO::getInstance();
		$this->eventController = new EventController();
		$this->placeEventController = new PlaceEventController();
		$this->artistController = new ArtistController();
		$this->seatTypeController = new SeatTypeController();
		$this->eventSeatController = new EventSeatController();
	}

	public function addCalendar($date, $eventId, $artistIdArray, $placeEventId, $eventSeatAttributesArray) {
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";

		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {

			//insercion de calendario en bd
			$calendarAttributes= array("date"=>$date, "eventId"=> $eventId);
			$this->dao->create($calendarAttributes);
			// guardo ultimo id de ultima instancia
			$calendarId= $this->dao->retrieveLastId();
			//instancio placeEvent a traves de el id
			$placeEvent=$this->placeEventController->getPlaceEventById($placeEventId);
			//instancio Event a traves de el id



			$event=$this->eventController->getEventById($eventId);

			foreach ($eventSeatAttributesArray as $value) {
				$eventSeat=new M_EventSeat($value['capacity'], $value['price'], $calendarId);
				$this->eventSeatController->addEventSeat($eventSeat);

			}
			
		

			$artists=array();
			foreach ($artistIdArray as $value) {
				$artist=$this->artistController->getArtistById($value);
				array_push($artists, $artist);
			}


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

	public function updateCalendar($id, $date, $eventId, $artistIdArray, $placeEventId, $id_seatType) {

		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$event=$this->eventController->getEventById($eventId);
			$placeEvent=$this->placeEventController->getPlaceEventById($placeEventId);
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

    public function getCalendarByEvent($string) {
        return $this->dao->retrieveEventsByString($string);
    }
	
}
?>