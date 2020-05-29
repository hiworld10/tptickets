<?php 

namespace app\controllers;

use app\models\Artist;
use app\dao\db\ArtistDAO as DB_ArtistDAO;
use app\dao\lists\ArtistDAO as List_ArtistDAO;
use app\controllers\Users;
use app\controllers\Auth;

class Artists extends \app\controllers\Authentication {

	private $dao;
	private $userController;

	public function __construct() {
        $this->requireAdminLogin();
		$this->dao = new DB_ArtistDAO();
		$this->userController = new Users();
	}

    public function index() {
            $artistArray = $this->dao->retrieveAll();
            require ADMIN_VIEWS . '/adminartist.php';
    }

	public function add($artistName) {
		$artist = new Artist(null, $artistName);
		$this->dao->create($artist);
		$this->index();
	}

	public function getAll() {
		return $this->dao->retrieveAll();
	}

    public function get($id) {
        $artist=$this->dao->retrieveById($id);      
    }

	public function edit($id) {
		$artist=$this->dao->retrieveById($id);		
		if(isset($artist)){
			require ADMIN_VIEWS . '/adminartist.php';
		}
	}

	public function update($id, $newName) {
		$updatedArtist = new Artist($id, $newName);
		$this->dao->update($updatedArtist);
		$this->index();
	}

    public function delete($id) {
        $this->dao->delete($id);
        $this->index();
    }

}

?>
