<?php 
namespace controllers;

use model\SeatType;
use dao\lists\SeatTypeDAO as List_SeatTypeDAO;
use dao\db\SeatTypeDAO as DB_SeatTypeDAO;


class SeatTypeController {

	private $dao;

	public function __construct() {
		$this->dao = new DB_SeatTypeDAO();
	}

	public function addSeatType($type) {

		$seatType = new SeatType(null, $type);
		$this->dao->create($seatType);
	
	}

	public function addSeatTypeandView($type) {

		$seatType = new SeatType(null, $type);
		$this->dao->create($seatType);
		$this->getAll();
	}

	public function getAll(){
		$seatTypeArray = $this->dao->retrieveAll(); 
		require ADMIN_VIEWS . '/adminseattype.php';
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
			require ADMIN_VIEWS . '/adminseattype.php';
		}

	}


	public function updateSeatType($id, $newType) {
		$updatedSeatType = new SeatType($id, $newType);
		$this->dao->update($updatedSeatType);
		$this->getAll();
	}

	

}

?>