<?php

namespace app\controllers\admin;

use app\models\Image;
use app\utils\Flash;
use core\View;

class Events extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireAdminLogin();

        $this->event_dao    = $this->dao('Event');
        $this->category_dao = $this->dao('Category');
        $this->bundle_dao = $this->dao('Bundle');
    }

    public function index()
    {
        $data['events']     = $this->event_dao->retrieveAll();
        $data['categories'] = $this->category_dao->retrieveAll();
        View::render('admin/events', $data);
    }

    public function add()
    {
        $this->redirectIfRequestIsNotPost('/admin/events');

        //Subida de imagen a la carpeta desginada de eventos
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
        } else {
            $image = null;
        }

        $rootImage = new Image();
        $rootImage->uploadImage($image, "events");
        //Se guarda la ruta de la imagen en string para ser almacenada en la BD
        $event['image'] = $rootImage->getPath();
        //Igual forma con el resto de los datos
        $event['id_category'] = $this->category_dao->retrieveById($_POST['category'])->getId();
        $event['name']        = trim($_POST['name']);
        //Finalmente se realiza el query y se redirecciona al index de eventos
        $this->event_dao->create($event);

        Flash::addMessage('Evento agregado.');
        $this->redirect('/admin/events');
    }

    public function addBundle($id)
    {
        $data['event'] = $this->event_dao->retrieveById($id);
        $data['bundles'] = $this->bundle_dao->retrieveAll();
        View::render('admin/add_bundle', $data);
    }

    public function setBundle($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/events');

        $this->event_dao->setBundle($id, $_POST['id_bundle']);

        Flash::addMessage('Paquete agregado a evento.');
        $this->redirect('/admin/events');
    }

    public function unsetBundle($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/events');

        $this->event_dao->unsetBundle($id);

        Flash::addMessage('Paquete removido de evento.');
        $this->redirect('/admin/events');
    }

    public function edit($id)
    {
        $data['event']      = $this->event_dao->retrieveById($id);
        $data['categories'] = $this->category_dao->retrieveAll();

        if (isset($data['event']) && isset($data['categories'])) {
            View::render('admin/events', $data);
        }
    }

    public function update($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/events');

        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
        } else {
            $image = null;
        }

        $rootImage = new Image();
        $rootImage->uploadImage($image, "events");

        $event['image']       = $rootImage->getPath();
        $event['id_event']    = $id;
        $event['id_category'] = $this->category_dao->retrieveById($_POST['category'])->getId();
        $event['name']        = trim($_POST['name']);

        $this->event_dao->update($event);

        Flash::addMessage('Evento actualizado.');
        $this->redirect('/admin/events');
    }

    public function delete($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/events');
        $this->handleDeleteCascadeConstraint($this->event_dao, $id);
        $this->redirect('/admin/events');
    }
}
