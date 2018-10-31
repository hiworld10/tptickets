<?php 
namespace controllers;
use model\Event as M_Event;
use dao\lists\EventDAO as List_EventDAO;
use dao\db\EventDAO as DB_EventDAO;
use controllers\CategoryController as CategoryController;

class EventController {

	private $dao;
	private $categoryController;

	public function __construct() {
		$this->dao = new DB_EventDAO();
		$this->categoryController = new CategoryController();
	}

	public function addEvent($name, $category) {
		$m_event = new M_event(null, $name, $category);
		$this->dao->create($m_event);
		$this->getAll();
	}

	public function getEvent($id) { 
		$event=$this->dao->retrieveById($id);
		$categoryArray = $this->categoryController->getAllSelect();	
		if(isset($event) && isset($categoryArray)) {
			include ADMIN_VIEWS . '/adminevent.php';
		}
	}

	public function getAll() {
		$eventArray = $this->dao->retrieveAll();
		$categoryArray = $this->categoryController->getAllSelect();
		include ADMIN_VIEWS. '/adminevent.php';
	}

	public function getAllSelect() {
		return $this->dao->retrieveAll();
	}

	public function deleteEvent($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateEvent($id, $newName, $newCategory) {
		$updatedEvent = new M_Event($id, $newName, $newCategory);
		$this->dao->update($updatedEvent);
		$this->getAll();
	}

	
}
?>