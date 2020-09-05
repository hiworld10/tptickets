<?php

namespace app\controllers\admin;

use app\utils\Flash;
use core\View;

class Artists extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->artist_dao = $this->dao('Artist');
    }

    /**
     * Lista los artistas en sistema.
     * @return void
     */
    public function index()
    {
        $data['artist_list'] = $this->artist_dao->retrieveAll();
        View::render('admin/artists', $data);
    }

    /**
     * Agrega un artista al sistema.
     */
    public function add()
    {
        $this->redirectIfRequestIsNotPost('/admin/artists');

        $data = ['name' => trim($_POST['name'])];
        $this->artist_dao->create($data);

        Flash::addMessage('Artista agregado.');
        $this->redirect('/admin/artists');
    }

    /**
     * Permite la edición de datos de un artista.
     * @param  $id El ID del artista
     * @return void
     */
    public function edit($id)
    {
        $data['artist'] = $this->artist_dao->retrieveById($id);
        if (isset($data['artist'])) {
            View::render('admin/artists', $data);
        }
    }

    /**
     * Actualiza los datos del artista.
     * @param  $id El ID del artista
     * @return void
     */
    public function update($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/artists');

        $data['id_artist'] = $id;
        $data['name']      = $_POST['name'];
        $this->artist_dao->update($data);

        Flash::addMessage('Artista actualizado.');
        $this->redirect('/admin/artists');
    }

    /**
     * Elimina un artista.
     * @param  $id El ID del artista a eliminar
     * @return void
     */
    public function delete($id)
    {
        //Se tendría que agregar una confirmación adicional para eliminar el item, para evitar el borrado accidental.
        $this->redirectIfRequestIsNotPost('/admin/artists');
        $this->handleDeleteCascadeConstraint($this->artist_dao, $id);
        $this->redirect('/admin/artists');
    }
}
