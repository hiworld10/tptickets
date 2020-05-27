<?php 

namespace app\controllers;

use app\models\Artist;
use app\dao\db\ArtistDAO as DB_ArtistDAO;
use app\dao\lists\ArtistDAO as List_ArtistDAO;
use app\controllers\Users;

class Artists {

	private $dao;
	private $userController;

	public function __construct() {
		$this->dao = new DB_ArtistDAO();
		$this->userController = new Users();
	}

    public function index() {
        /*Si el usuario no es admin, la controladora no permitira acceder a los datos.
          Ver si es posible imprimir un mensaje de alerta advirtiendo que el usuario no
          tiene permiso para acceder a la pagina. Aplicar esta comprobacion en los otros metodos. NOTE: Esto deberia modificarse para mayor eficiencia de codigo*/
        //if (!$this->userController->isUserAdmin()) {
        //    echo "Debe iniciar sesion para ver esta pagina.";
        //    $this->userController->loginScreen();
        //} else {
            $artistArray = $this->dao->retrieveAll();
            require ADMIN_VIEWS . '/adminartist.php';
        //}
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
