<?php

namespace app\controllers;

use app\models\Photo;

class Events extends \app\controllers\Authentication {

	public function __construct() {
        $this->requireAdminLogin();
		$this->event_dao = $this->dao('Event');
        $this->category_dao = $this->dao('Category');		
	}

    public function index() {
        $data['events'] = $this->event_dao->retrieveAll();
        $data['categories'] = $this->category_dao->retrieveAll();
        $this->view('admin/events', $data);
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