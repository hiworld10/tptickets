<?php 
namespace dao\lists;


class ArtistXCalendarDAO implements IDAO
{
	private $list;

	function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_SESSION["artistxcalendar"])) {
			$this->list = $_SESSION["artistxcalendar"];
		} 
		else {
			$this->list = array();
			$_SESSION["artistxcalendar"] = 0;
		}
	}

	public function create($newVal) {
		if (isset($_SESSION["artistxcalendar"])) {
			$this->list = $_SESSION["artistxcalendar"];
		} 
		$newVal->setId(++$_SESSION["idartistxcalendar"]);
		array_push($this->list, $newVal);

		$_SESSION["artistxcalendar"] = $this->list;
	}

	public function retrieveById($id) {
		if (isset($_SESSION["artistxcalendar"])) {
			$this->list = $_SESSION["artistxcalendar"];

			foreach ($this->list as $key => $value) {
				if ($id == $value->getId()) {
					return $value;
				}
			}
		}

		return false;
	}

	public function retrieveAll() {
		if(isset($_SESSION['artistxcalendar'])) {
			$this->list = $_SESSION['artistxcalendar'];

			return $this->list;

		}
		return false;
	}

	public function update($newVal){
		if(isset($_SESSION['artistxcalendar'])) {
			$this->list = $_SESSION['artistxcalendar'];

			foreach ($this->list as $key => $value) {
				if ($newVal->getId() == $value->getId()) {
					$value = $newVal();
				}
			}
		}
		$_SESSION['artistxcalendar'] = $this->list;
	}

	public function delete($id) {


		if(isset($_SESSION['artistxcalendar']))
		{

			$list= $_SESSION['artistxcalendar'];
			foreach ($list as $key => $value) {
				if($id == $value->getId()){
					unset($list[$key]);	
				}

				$_SESSION['artistxcalendar']= $list;
			}
		}
	}

}
?>