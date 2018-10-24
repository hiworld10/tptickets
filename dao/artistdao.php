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
			$_SESSION["idartist"] = 0;
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["artists"])) {
			$this->list = $_SESSION["artists"];

		} 
		$newVal->setId(++$_SESSION["idartist"]);
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
	


public function updateArtist($newName) {
	if(isset($_SESSION['artists'])) {
			$this->list = $_SESSION['artists'];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					$value->setName($newName);
				}
			}
	}


}
public function update($val){

}

public function delete($id){

	
		if(isset($_SESSION['artists']))
		{

			$list= $_SESSION['artists'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);
				
					
				}

			$_SESSION['artists']= $list;
		}
			
			
		
		
	}

}

}
?>