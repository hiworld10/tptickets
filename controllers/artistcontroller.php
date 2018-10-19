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
		include ROOT . '/views/home.php';
	}


}

?>
