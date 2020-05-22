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

    public function index() {
        $eventArray = $this->dao->retrieveAll();
        $categoryArray = $this->categoryController->getAll();
        require ADMIN_VIEWS. '/adminevent.php';
    }

	public function add($name, $categoryId) {
		if (!empty($_FILES['photo']['name'])) {
			$photo = $_FILES['photo'];

		} else {
			$photo = null;
		}

		$rootPhoto= new Photo();
		$rootPhoto->uploadPhoto($photo, "events");

		$category = $this->categoryController->get($categoryId);
		$event = new Event(null, $name, $category, $rootPhoto);
		$this->dao->create($event);
		$this->index();
	}

	public function edit($id) { 
		$event = $this->dao->retrieveById($id);
		$categoryArray = $this->categoryController->getAll();	
		if(isset($event) && isset($categoryArray)) {
			require ADMIN_VIEWS . '/adminevent.php';
		}
	}

	public function getAll() {
		return $this->dao->retrieveAll();
	}

    public function getById($id) { 
        return $this->dao->retrieveById($id);
    }

    public function getByString($string) {
        return $this->dao->retrieveByString($string);
    }

	public function update($id, $newName, $categoryId) {
		if (!empty($_FILES['photo']['name'])) {
			$photo = $_FILES['photo'];

		} else {
			$photo = null;
		}

		$rootPhoto = new Photo();
		$rootPhoto->uploadPhoto($photo, "events");

		$newCategory = $this->categoryController->get($categoryId);
		$updatedEvent = new Event($id, $newName, $newCategory, $rootPhoto);
		$this->dao->update($updatedEvent);
		$this->index();
	}
	
    public function delete($id) {
        $this->dao->delete($id);
        $this->index();
    }
}
?>