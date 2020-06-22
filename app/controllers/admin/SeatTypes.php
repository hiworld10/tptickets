<?php

namespace app\controllers\admin;

use app\utils\Flash;

class SeatTypes extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireAdminLogin();
        
        $this->dao = $this->dao('SeatType');
    }

    public function index()
    {
        $data['seat_types'] = $this->dao->retrieveAll();
        $this->view('admin/seat_types', $data);
    }

    public function add()
    {
        $this->redirectIfRequestIsNotPost('admin/seat-types');

        $seat_type['description'] = trim($_POST['description']);
        $this->dao->create($seat_type);

        Flash::addMessage('Tipo de plaza agregado.');
        $this->redirect('admin/seat-types');
    }

    public function edit($id)
    {
        $data['seat_type'] = $this->dao->retrieveById($id);
        if (isset($data['seat_type'])) {
            $this->view('admin/seat_types', $data);
        }
    }

    public function update($id)
    {
        $this->redirectIfRequestIsNotPost('admin/seat-types');

        $seat_type['id_seat_type'] = $id;
        $seat_type['description']  = trim($_POST['description']);
        $this->dao->update($seat_type);

        Flash::addMessage('Tipo de plaza actualizado.');
        $this->redirect('admin/seat-types');
    }

    public function delete($id)
    {
        $this->redirectIfRequestIsNotPost('admin/seat-types');

        $this->dao->delete($id);

        Flash::addMessage('Tipo de plaza eliminado.');
        $this->redirect('admin/seat-types');
    }
}
