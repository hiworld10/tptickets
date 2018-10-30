<?php 
namespace controllers;
use model\Calendar as M_Calendar;
use dao\lists\CalendarDAO as List_CalendarDAO;
use dao\db\CalendarDAO as DB_CalendarDAO;
use controllers\EventController as EventController;

class CalendarController {

	private $dao;
	private $eventController;

	public function __construct() {
		$this->dao = new DB_CalendarDAO();
		$this->eventController = new EventController();
	}

	public function addCalendar($date, $eventId) {
		
		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$m_calendar = new M_Calendar(null, $date, $eventId);
			$this->dao->create($m_calendar);
			$this->getAll();
		}
	}

	public function getCalendar($id) { 
		$calendar=$this->dao->retrieveById($id);
		$eventArray = $this->eventController->getAllSelect();	
		if(isset($calendar) && isset($eventArray)) {
			include ADMIN_VIEWS . '/admincalendar.php';
		}
	}

	public function getAll() {
		$calendarArray = $this->dao->retrieveAll();
		$eventArray = $this->eventController->getAllSelect();
		include ADMIN_VIEWS. '/admincalendar.php';
	}

	public function deleteCalendar($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateCalendar($id, $date, $newEventId) {

		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
		} else {
			$updatedCalendar = new M_Calendar($id, $date, $newEventId);
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