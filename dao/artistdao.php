<?php 
namespace dao;


class ArtistDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["artists"])) {
			$this->list = $_SESSION["artists"];
		} 
		else {
			$this->list = array();
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["artists"])) {
			$this->list = $_SESSION["artists"];
		} 

		array_push($this->list, $newVal);

		$_SESSION["artists"] = $this->list;

	}

	public function getById($id) {
		if (isset($_SESSION["artists"])) {
			$this->list = $_SESSION["artists"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	//PARAMETROS ???
	public function retrieve() {
		if(isset($_SESSION['artists'])) {
			$this->list = $_SESSION['artists'];

			return $this->list;

		}
		return false;
	}
	


public function update($newVal) {

}

public function delete($newVal) {

}




}
?>