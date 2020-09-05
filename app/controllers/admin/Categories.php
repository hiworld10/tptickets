<?php

namespace app\controllers\admin;

use app\utils\Flash;
use core\View;

class Categories extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->dao = $this->dao('Category');
    }
    /**
     * Lista las categorías en sistema.
     * @return void
     */
    public function index()
    {
        $data['categories'] = $this->dao->retrieveAll();
        View::render('admin/categories', $data);
    }
    /**
     * Agrega una categoría al sistema.
     */
    public function add()
    {
        $this->redirectIfRequestIsNotPost('/admin/categories');

        $category['type'] = trim($_POST['type']);
        $this->dao->create($category);

        Flash::addMessage('Categoría agregada.');
        $this->redirect('/admin/categories');
    }
    /**
     * Permite la edición de datos de una categoría.
     * @param  $id El ID de la categoría
     * @return void
     */
    public function edit($id)
    {
        $data['category'] = $this->dao->retrieveById($id);

        if (isset($data['category'])) {
            View::render('admin/categories', $data);
        }
    }

    /**
     * Actualiza los datos de la categoría.
     * @param  $id El ID de la categoría
     * @return void
     */
    public function update($id)
    {

        $this->redirectIfRequestIsNotPost('/admin/categories');

        $category['id_category'] = $id;
        $category['type']        = trim($_POST['type']);

        $this->dao->update($category);

        Flash::addMessage('Categoría actualizada.');
        $this->redirect('/admin/categories');
    }
    /**
     * Elimina una categoría.
     * @param  $id El ID de la categoría a eliminar
     * @return void
     */
    public function delete($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/categories');
        $this->handleDeleteCascadeConstraint($this->dao, $id);
        $this->redirect('/admin/categories');
    }
}
