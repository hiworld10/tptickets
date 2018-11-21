<?php 
namespace controllers;
use model\EventSeat as M_EventSeat;
use dao\lists\EventSeatDAO as List_EventSeatDAO;
use dao\db\EventSeatDAO as DB_EventSeatDAO;
use controllers\CalendarController as CalendarController;
use controllers\SeatTypeController as SeatTypeController;

class EventSeatController {

	private $dao;
	private $calendarController;
	private $seatTypeController;

	public function __construct() {
		$this->dao = new DB_EventSeatDAO();
	
		$this->seatTypeController = new SeatTypeController();
	}

	public function addEventSeat($availableSeats, $price, $calendarId, $seatTypeId) {
		$m_eventSeat = new M_EventSeat(null, $calendarId, $seatTypeId, $availableSeats, $price);
		$this->dao->create($m_eventSeat);
		print_r($m_eventSeat);
		$this->getAll();
	}

	public function getEventSeat($id) { 
		$eventSeat=$this->dao->retrieveById($id);
		$calendarArray = $this->calendarController->getAllSelect();	
		$seatTypeArray = $this->seatTypeController->getAllSelect();	
		if(isset($eventSeat) && isset($calendarArray) && isset($seatTypeArray)) {
			include ADMIN_VIEWS . '/admineventseat.php';
		}
	}

	public function getAll() {
		$eventSeatArray = $this->dao->retrieveAll();
		$calendarArray = $this->calendarController->getAllSelect();
		$seatTypeArray = $this->seatTypeController->getAllSelect();
		include ADMIN_VIEWS. '/admineventseat.php';
	}
	
	public function getAllSelect(){
		return $this->dao->retrieveAll();
	}

	public function deleteEventSeat($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateEventSeat($id, $availableSeats, $price, $calendarId, $seatTypeId) {
		$updatedEventSeat = new M_EventSeat($id, $availableSeats, $price, $calendarId, $seatTypeId);
		$this->dao->update($updatedEventSeat);
		$this->getAll();
	}

	
}
?>