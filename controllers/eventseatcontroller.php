<?php 
namespace controllers;
use model\EventSeat as M_EventSeat;
use dao\lists\EventSeatDAO as List_EventSeatDAO;
use dao\db\EventSeatDAO as DB_EventSeatDAO;
use controllers\SeatTypeController as SeatTypeController;

class EventSeatController {

	private $dao;
	private $seatTypeController;

	public function __construct() {
		$this->dao = new DB_EventSeatDAO();
	
		$this->seatTypeController = new SeatTypeController();
	}

	public function addEventSeat($calendarId, $seatType, $availableSeats, $price) {
        $remainder = $availableSeats;
		$m_eventSeat = new M_EventSeat(null, $calendarId, $seatType, $availableSeats, $price, $remainder);
		$this->dao->create($m_eventSeat);
	}

	public function addEventSeatAndView($calendarId, $seatType, $availableSeats, $price) {
        $remainder = $availableSeats;
		$m_eventSeat = new M_EventSeat(null,$calendarId, $seatType, $availableSeats, $price, $remainder);
		$this->dao->create($m_eventSeat);
		$this->getAll();
	}

	public function getEventSeat($id) { 
		$eventSeat=$this->dao->retrieveById($id);
		$seatTypeArray = $this->seatTypeController->getAllSelect();	
		if(isset($eventSeat) && isset($calendarArray) && isset($seatTypeArray)) {
			include ADMIN_VIEWS . '/admineventseat.php';
		}
	}

	public function getAll() {
		$eventSeatArray = $this->dao->retrieveAll();
		$seatTypeArray = $this->seatTypeController->getAllSelect();
		include ADMIN_VIEWS . '/admineventseat.php';
		
	}
	
	public function getAllSelect(){
		return $this->dao->retrieveAll();
	}

	public function deleteEventSeat($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateEventSeat($id, $calendarId, $seatType, $availableSeats, $price) {

		$updatedEventSeat = new M_EventSeat($id, $calendarId, $seatType, $availableSeats, $price);
		$this->dao->update($updatedEventSeat);
		$this->getAll();
	}

	public function getByCalendarId($idCalendar)
	{
		return $this->dao->retrieveByCalendarId($idCalendar);		
	}
}
?>