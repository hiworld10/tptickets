<?php 
namespace controllers;

use model\SeatType as M_SeatType;
use dao\lists\SeatTypeDAO as List_SeatTypeDAO;
use dao\db\SeatTypeDAO as DB_SeatTypeDAO;


class SeatTypeController {

	private $dao;

	public function __construct() {
		$this->dao = DB_SeatTypeDAO::getInstance();
	}

	public function addSeatType($type) {

		$m_seattype = new M_SeatType(null, $type);
		$this->dao->create($m_seattype);
		$this->getAll();
	}

	public function getAll(){
		$seatTypeArray = $this->dao->retrieveAll(); 
		include ADMIN_VIEWS . '/adminseattype.php';
	}

	public function getAllSelect(){
		return $this->dao->retrieveAll();
	}
	

	public function deleteSeatType($id){

		$this->dao->delete($id);
		$this->getAll();
	}


	public function getSeatTypeById($id){
		 return $seattype=$this->dao->retrieveById($id);	
		
	
	}
	public function getSeatType($id){
		$seattype=$this->dao->retrieveById($id);

		if(isset($seattype)){
			include ADMIN_VIEWS . '/adminseattype.php';
		}

	}


	public function updateSeatType($id, $newType) {
		$updatedSeatType = new M_SeatType($id, $newType);
		$this->dao->update($updatedSeatType);
		$this->getAll();
	}

	

}

?>