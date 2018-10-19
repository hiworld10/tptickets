<?php 
namespace controllers;

use model\Calendar as M_Calendar;
use dao\CalendarDAO as CalendarDAO;


class ArtistController {

	private $dao;

	public function __construct() {
		$this->dao = new CalendarDAO();
	}

	public function addCalendar($date) {

		$m_calendar = new M_Calendar($date);
		$this->dao->create($m_calendar);
		$this->getAll();


	}

	public function getAll(){
		$calendarArray = $this->dao->retrieve(); 
		include ROOT . '/views/home.php';
	}


}

?>