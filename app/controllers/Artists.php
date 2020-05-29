<?php 

namespace app\controllers;

class Artists extends \app\controllers\Authentication {

	public function __construct() {
        $this->requireAdminLogin();
		$this->artist_dao = $this->dao('Artist');
	}

    public function index() {
            $data['artist_list'] = $this->artist_dao->retrieveAll();
            $this->view('admin/artists', $data);
    }

	public function add() {
        $this->redirectIfRequestIsNotPost('artists');

        $data = ['name' => trim($_POST['name'])];
        $this->artist_dao->create($data);
		
		$this->redirect('artists');
	}

	public function edit($id) {
		$data['artist'] = $this->artist_dao->retrieveById($id);		
		if(isset($data['artist'])) {
            $this->view('admin/artists', $data);
		}
	}

	public function update($id) {
        $this->redirectIfRequestIsNotPost('artists');

        $data['id_artist'] = $id;
    	$data['name'] = $_POST['name'];
    	$this->artist_dao->update($data);
    
        $this->redirect('artists');
	}

    public function delete($id) {
        //Se tendría que agregar una confirmación adicional para eliminar el item, para evitar el borrado accidental.
        $this->redirectIfRequestIsNotPost('artists');

        $this->artist_dao->delete($id);

        $this->redirect('artists');
    }

}

?>
