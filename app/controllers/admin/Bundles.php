<?php

namespace app\controllers\admin;

use app\utils\Flash;
use core\View;

class Bundles extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->bundle_dao = $this->dao('bundle');
    }
    /**
     * Lista los paquetes de descuento en sistema.
     * @return void
     */
    public function index()
    {
        $data['bundles'] = $this->bundle_dao->retrieveAll();
        View::render('admin/bundles', $data);
    }

    /**
     * Agrega un paquete de descuento al sistema.
     */
    public function add()
    {
        $this->redirectIfRequestIsNotPost('/admin/bundles');

        $data = [
            'description' => trim($_POST['description']),
            'discount'    => trim($_POST['discount']),
        ];
        $this->bundle_dao->create($data);

        Flash::addMessage('Paquete agregado.');
        $this->redirect('/admin/bundles');
    }
    /**
     * Permite la edición de datos de un paquete de descuento.
     * @param  $id El ID del paquete de descuento
     * @return void
     */
    public function edit($id)
    {
        $data['bundle'] = $this->bundle_dao->retrieveById($id);
        if (isset($data['bundle'])) {
            View::render('admin/bundles', $data);
        }
    }
    /**
     * Actualiza los datos del paquete de descuento.
     * @param  $id El ID del paquete de descuento
     * @return void
     */
    public function update($id)
    {
        $this->redirectIfRequestIsNotPost('/admin/bundles');

        $data['id_bundle']   = $id;
        $data['description'] = $_POST['description'];
        $data['discount']    = $_POST['discount'];
        $this->bundle_dao->update($data);

        Flash::addMessage('Paquete actualizado.');
        $this->redirect('/admin/bundles');
    }
    /**
     * Elimina un paquete de descuento.
     * @param  $id El ID del paquete de descuento a eliminar
     * @return void
     */
    public function delete($id)
    {
        //Se tendría que agregar una confirmación adicional para eliminar el item, para evitar el borrado accidental.
        $this->redirectIfRequestIsNotPost('/admin/bundles');
        $this->handleDeleteCascadeConstraint($this->bundle_dao, $id);
        $this->redirect('/admin/bundles');
    }
}
