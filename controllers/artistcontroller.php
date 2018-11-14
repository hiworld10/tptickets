<?php 
namespace controllers;

use model\Artist as M_Artist;
use dao\db\ArtistDAO as DB_ArtistDAO;
use dao\lists\ArtistDAO as List_ArtistDAO;


class ArtistController {

	private $dao;

	public function __construct() {
		$this->dao = new DB_ArtistDAO();
	}

	public function addArtist($artistName) {

		$m_artist = new M_Artist(null, $artistName);
		$this->dao->create($m_artist);
		$this->getAll();
	}

	public function getAll(){
		$artistArray = $this->dao->retrieveAll(); 
		include ADMIN_VIEWS . '/adminartist.php';

	}
	public function getAllSelect(){
		return $this->dao->retrieveAll(); 


	}

	public function deleteArtist($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function getArtist($id){
		$artist=$this->dao->retrieveById($id);		
		if(isset($artist)){
			include ADMIN_VIEWS . '/adminartist.php';
		}
	}

	public function getArtistById($id){
		$artist=$this->dao->retrieveById($id);		
	
	}



	
	public function updateArtist($id, $newName){
		$updatedArtist = new M_Artist($id, $newName);
		$this->dao->update($updatedArtist);
		$this->getAll();
	}

	
}

?>
