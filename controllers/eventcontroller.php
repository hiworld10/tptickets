<?php 
namespace controllers;
use model\Event as M_Event;
use dao\lists\EventDAO as List_EventDAO;
use dao\lists\CategoryDAO as List_CategoryDAO;
use controllers\CategoryController as CategoryController;
class EventController {
	private $dao;
	private $categorydao;
	public function __construct() {
		$this->dao = new List_EventDAO();
		$this->categorydao = new List_CategoryDAO();
	}
	public function addEvent($name, $categoryId) {
		$m_category = $this->categorydao->retrieveById($categoryId);
		$m_event = new M_event($name, $m_category);
		$this->dao->create($m_event);
		$this->getAll();
	}
	public function getEvent($id) {
		$categoryArray = $this->categorydao->retrieveAll(); 
		$category=$this->dao->retrieveById($id);		
		if(isset($category)){
			include ADMIN_VIEWS . '/adminevent.php';
		}
	}
	public function getAll() {
		$eventArray = $this->dao->retrieveAll(); 
		$categoryArray = $this->categorydao->retrieveAll(); 
		include ADMIN_VIEWS. '/adminevent.php';
	}
	public function deleteEvent($id){

		$this->dao->delete($id);
		$this->getAll();
	}
	public function updateEvent($id, $newName, $newType) {
		$updatedEvent = new M_Category($id,$newName, $newType);
		$this->dao->update($updatedCategory);
		$this->getAll();
	}

	
}
?>