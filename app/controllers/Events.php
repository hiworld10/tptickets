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

	public function add() {
        $this->redirectIfRequestIsNotPost('events');

        //Subida de imagen a la carpeta desginada de eventos
		if (!empty($_FILES['photo']['name'])) {
			$photo = $_FILES['photo'];

		} else {
			$photo = null;
		}
		$rootPhoto= new Photo();
		$rootPhoto->uploadPhoto($photo, "events");
        //Se guarda la ruta de la imagen en string para ser almacenada en la BD
        $event['image'] = $rootPhoto->getPath();
        //Igual forma con el resto de los datos
		$event['id_category'] = $this->category_dao->retrieveById($_POST['category'])->getId();
        $event['name'] = trim($_POST['name']);
        //Finalmente se realiza el query y se redirecciona al index de eventos
		$this->event_dao->create($event);

		$this->redirect('events');
	}

	public function edit($id) { 
		$data['event'] = $this->event_dao->retrieveById($id);
		$data['categories'] = $this->category_dao->retrieveAll();	
		if(isset($data['event']) && isset($data['categories'])) {
			$this->view('admin/events', $data);
		}
	}

	public function update($id) {
        $this->redirectIfRequestIsNotPost('events');

		if (!empty($_FILES['photo']['name'])) {
			$photo = $_FILES['photo'];

		} else {
			$photo = null;
		}

		$rootPhoto = new Photo();
		$rootPhoto->uploadPhoto($photo, "events");

        $event['image'] = $rootPhoto->getPath();
        $event['id_event'] = $id;
        $event['id_category'] = $this->category_dao->retrieveById($_POST['category'])->getId();
        $event['name'] = trim($_POST['name']);
        $this->event_dao->update($event);

		$this->redirect('events');
	}
	
    public function delete($id) {
        $this->redirectIfRequestIsNotPost('events');
        
        $this->event_dao->delete($id);
        
        $this->redirect('events');
    }
}
?>