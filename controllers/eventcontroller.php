<?php 
namespace controllers;

use model\Event as M_Event;
use dao\EventDAO as EventDAO;


class EventController {

	private $dao;

	public function __construct() {
		$this->dao = new EventDAO();
	}

	public function addEvent($name, $date) {

		$m_event = new M_event($name, $date);
		$this->dao->create($m_event);
		$this->getAll();

	}

	public function getAll(){
		$eventArray = $this->dao->retrieve(); 
		include ROOT . '/views/home.php';
	}


}

?>
