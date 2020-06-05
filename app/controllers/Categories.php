<?php 

namespace app\controllers;

use app\utils\Flash;

class Categories extends \app\controllers\Authentication {

	public function __construct() {
        $this->requireAdminLogin();
		$this->dao = $this->dao('Category');
	}

	public function index() {
		
		$data['categories'] = $this->dao->retrieveAll(); 
		$this->view('admin/categories', $data);
	}

    public function add() {
        $this->redirectIfRequestIsNotPost('categories');

        $category['type'] = trim($_POST['type']); 
        $this->dao->create($category);

        Flash::addMessage('Categoría agregada.');
        $this->redirect('categories');
    }

	public function edit($id) {
		$data['category'] = $this->dao->retrieveById($id);		
		if(isset($data['category'])) {
            $this->view('admin/categories', $data);
		}
	}

	public function update($id) {

        $this->redirectIfRequestIsNotPost('categories');

        $category['id_category'] = $id;
        $category['type'] = trim($_POST['type']);
		$this->dao->update($category);

        Flash::addMessage('Categoría actualizada.');
		$this->redirect('categories');
	}

    public function delete($id) {
        $this->redirectIfRequestIsNotPost('categories');
        
        $this->dao->delete($id);
        Flash::addMessage('Categoría eliminada.');
        $this->redirect('categories');
    }
}
?>
