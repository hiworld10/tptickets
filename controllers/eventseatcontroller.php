<?php 
namespace controllers;
use model\EventSeat;
use dao\lists\EventSeatDAO as List_EventSeatDAO;
use dao\db\EventSeatDAO as DB_EventSeatDAO;
use controllers\SeatTypeController;

class EventSeatController {

	private $dao;
	private $seatTypeController;

	public function __construct() {
		$this->dao = new DB_EventSeatDAO();
	
		$this->seatTypeController = new SeatTypeController();
	}

	public function addEventSeat($calendarId, $seatType, $availableSeats, $price) {
        $remainder = $availableSeats;
		$eventSeat = new EventSeat(null, $calendarId, $seatType, $availableSeats, $price, $remainder);
		$this->dao->create($eventSeat);
	}

	public function addEventSeatAndView($calendarId, $seatType, $availableSeats, $price) {
        $remainder = $availableSeats;
		$eventSeat = new EventSeat(null,$calendarId, $seatType, $availableSeats, $price, $remainder);
		$this->dao->create($eventSeat);
		$this->getAll();
	}

	public function getEventSeat($id) { 
		$eventSeat=$this->dao->retrieveById($id);
		$seatTypeArray = $this->seatTypeController->getAll();	
		if(isset($eventSeat) && isset($calendarArray) && isset($seatTypeArray)) {
			require ADMIN_VIEWS . '/admineventseat.php';
		}
	}

	public function index() {
		$eventSeatArray = $this->dao->retrieveAll();
		$seatTypeArray = $this->seatTypeController->getAll();
		require ADMIN_VIEWS . '/admineventseat.php';
		
	}
	
	public function getAllSelect(){
		return $this->dao->retrieveAll();
	}

	public function deleteEventSeat($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateEventSeat($id, $calendarId, $seatType, $availableSeats, $price) {

        $remainder = $availableSeats;

		$updatedEventSeat = new EventSeat($id, $calendarId, $seatType, $availableSeats, $price, $remainder);
		
		$this->dao->update($updatedEventSeat);
		
	}

	public function getByCalendarId($idCalendar)
	{
		return $this->dao->retrieveByCalendarId($idCalendar);		
	}
}
?>