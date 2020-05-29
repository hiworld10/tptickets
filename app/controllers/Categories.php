<?php 

namespace app\controllers;

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

		$this->redirect('categories');
	}

    public function delete($id) {
        $this->redirectIfRequestIsNotPost('categories');
        
        $this->dao->delete($id);
        
        $this->redirect('categories');
    }
}
?>
