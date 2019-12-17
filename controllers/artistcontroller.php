<?php 
namespace controllers;

use model\Artist;
use dao\db\ArtistDAO as DB_ArtistDAO;
use dao\lists\ArtistDAO as List_ArtistDAO;
use controllers\UserController;

class ArtistController {

	private $dao;
	private $userController;

	public function __construct() {
		$this->dao = new DB_ArtistDAO();
		$this->userController = new UserController();
	}

	public function addArtist($artistName) {
		$artist = new Artist(null, $artistName);
		$this->dao->create($artist);
		$this->getAll();
	}

	public function getAll() {
		/*Si el usuario no es admin, la controladora no permitira acceder a los datos.
		  Ver si es posible imprimir un mensaje de alerta advirtiendo que el usuario no
		  tiene permiso para acceder a la pagina. Aplicar esta comprobacion en los otros metodos*/
		if (!$this->userController->isUserAdmin()) {
			$this->userController->index();
		} else {
			$artistArray = $this->dao->retrieveAll();
			require ADMIN_VIEWS . '/adminartist.php';
		}
	}

	public function getAllSelect() {
		return $this->dao->retrieveAll();
	}

	public function deleteArtist($id) {
		$this->dao->delete($id);
		$this->getAll();
	}

	public function getArtist($id) {
		$artist=$this->dao->retrieveById($id);		
		if(isset($artist)){
			require ADMIN_VIEWS . '/adminartist.php';
		}
	}

	public function getArtistById($id) {
		$artist=$this->dao->retrieveById($id);		
	}

	public function updateArtist($id, $newName) {
		$updatedArtist = new Artist($id, $newName);
		$this->dao->update($updatedArtist);
		$this->getAll();
	}
}

?>
