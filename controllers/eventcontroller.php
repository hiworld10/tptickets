<?php 
namespace controllers;

use model\Event as M_Event;
use dao\lists\EventDAO as List_EventDAO;
use controllers\CategoryController as CategoryController


class EventController {

	private $dao;
	private $categoryController;

	public function __construct() {
		$this->dao = new List_EventDAO();
		$this->categoryController = new CategoryController();
	}

	public function addEvent($name, $categoryId) {

		$m_category = $categoryController->retrieveById($categoryId);
		$m_event = new M_event($name, $m_category);
		$this->dao->create($m_event);
		$this->getAll();

	}

	public function getEvent($id) {
		$category=$this->dao->retrieveById($id);		
		if(isset($category)){
			include ADMIN_VIEWS . '/adminevent.php';
		}
	}

	public function getAll() {
		$eventArray = $this->dao->retrieveById(); 
		include ROOT . '/views/adminevent.php';
	}
}

?>
