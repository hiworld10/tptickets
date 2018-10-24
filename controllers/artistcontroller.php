<?php 
namespace controllers;

use model\Artist as M_Artist;
use dao\ArtistDAO as ArtistDAO;


class ArtistController {

	private $dao;

	public function __construct() {
		$this->dao = new ArtistDAO();
	}

	public function addArtist($artist) {

		$m_artist = new M_Artist();
		$m_artist->setName($artist);
		$this->dao->create($m_artist);
		$this->getAll();


	}

	public function getAll(){
		$artistArray = $this->dao->retrieve(); 
		include ADMIN_VIEWS . '/adminartist.php';

	}


	public function deleteArtist($id){

		$this->dao->delete($id);
		$this->getAll();
	}

	public function getArtist($id){
		$artist=$this->dao->getById($id);		
		if(isset($artist)){
			include ADMIN_VIEWS . '/adminartist.php';
		}
		

	}


	public function updateArtist($newName){
		$artist->setName($newName);
		

	}




}

?>
