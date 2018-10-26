<?php 
namespace dao\list;


class CategoryDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			
			session_start();
		}
		if (isset($_SESSION["categories"])) {
			$this->list = $_SESSION["categories"];
		} 
		else {
			$this->list = array();
			$_SESSION["idcategory"] = 0;
		}

	}

	public function create($newVal) {
		if (isset($_SESSION["categories"])) {
			$this->list = $_SESSION["categories"];
		} 
		$newVal->setId(++$_SESSION["idcategory"]);
		array_push($this->list, $newVal);

		$_SESSION["categories"] = $this->list;

	}

	public function retrieveById($id) {
		if (isset($_SESSION["categories"])) {
			$this->list = $_SESSION["categories"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}


	public function retrieveAll() {
		if(isset($_SESSION['categories'])) {
			$this->list = $_SESSION['categories'];
			return $this->list;

		}
		return false;
	}
	


	public function update($newVal) {
		if(isset($_SESSION['categories'])) {
			$this->list = $_SESSION['categories'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value->setType($newVal->getType());
				}
			}
		}
		$_SESSION['categories'] = $this->list;
	}

	public function delete($id) {

		if(isset($_SESSION['categories']))
		{

			$list= $_SESSION['categories'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['categories']= $list;
			}
		}
	}

}
?>