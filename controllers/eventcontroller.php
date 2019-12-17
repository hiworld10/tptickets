<?php

namespace controllers;
use model\Event;
use model\Photo;
use dao\lists\EventDAO as List_EventDAO;
use dao\db\EventDAO as DB_EventDAO;
use controllers\CategoryController;

class EventController {

	private $dao;
	private $categoryController;

	public function __construct() {
		$this->dao = new DB_EventDAO();
		$this->categoryController = new CategoryController();
		
	}

	public function addEvent($name, $categoryId) {
		if (!empty($_FILES['photo']['name'])) {
			$photo = $_FILES['photo'];

		} else {
			$photo = null;
		}

		$rootPhoto= new Photo();
		$rootPhoto->uploadPhoto($photo, "events");

		$category = $this->categoryController->getCategorySelect($categoryId);
		$event = new Event(null, $name, $category, $rootPhoto);
		$this->dao->create($event);
		$this->getAll();
	}

	public function getEvent($id) { 
		$event = $this->dao->retrieveById($id);
		$categoryArray = $this->categoryController->getAllSelect();	
		if(isset($event) && isset($categoryArray)) {
			require ADMIN_VIEWS . '/adminevent.php';
		}
	}

	public function getEventById($id) { 
		return $this->dao->retrieveById($id);
	}

	public function getAll() {
		$eventArray = $this->dao->retrieveAll();
		$categoryArray = $this->categoryController->getAllSelect();
		require ADMIN_VIEWS. '/adminevent.php';
	}

	public function getAllSelect() {
		return $this->dao->retrieveAll();
	}

	public function deleteEvent($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateEvent($id, $newName, $categoryId) {
		if (!empty($_FILES['photo']['name'])) {
			$photo = $_FILES['photo'];

		} else {
			$photo = null;
		}

		$rootPhoto = new Photo();
		$rootPhoto->uploadPhoto($photo, "events");

		$newCategory = $this->categoryController->getCategorySelect($categoryId);
		$updatedEvent = new Event($id, $newName, $newCategory, $rootPhoto);
		$this->dao->update($updatedEvent);
		$this->getAll();
	}

    public function getEventsByString($string) {
        return $this->dao->retrieveByString($string);
    }
	
}
?>