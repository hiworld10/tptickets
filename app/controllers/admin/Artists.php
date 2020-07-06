<?php

namespace app\controllers\admin;

use app\utils\Flash;

class Artists extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->artist_dao = $this->dao('Artist');
    }

    public function index()
    {
        $data['artist_list'] = $this->artist_dao->retrieveAll();
        $this->view('admin/artists', $data);
    }

    public function add()
    {
        $this->redirectIfRequestIsNotPost('/admin/artists');

        $data = ['name' => trim($_POST['name'])];
        $this->artist_dao->create($data);

        Flash::addMessage('Artista agregado.');
        $this->redirect('/admin/artists');
    }

    public function edit($id)
    {
        $data['artist'] = $this->artist_dao->retrieveById($id);
        if (isset($data['artist'])) {
            $this->view('admin/artists', $data);
        }
    }

    public function update($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/artists');

        $data['id_artist'] = $id;
        $data['name']      = $_POST['name'];
        $this->artist_dao->update($data);

        Flash::addMessage('Artista actualizado.');
        $this->redirect('/admin/artists');
    }

    public function delete($id)
    {
        //Se tendría que agregar una confirmación adicional para eliminar el item, para evitar el borrado accidental.
        $this->redirectIfRequestIsNotPost('/admin/artists');
        $this->handleDeleteCascadeConstraint($this->artist_dao, $id);
        $this->redirect('/admin/artists');
    }
}
