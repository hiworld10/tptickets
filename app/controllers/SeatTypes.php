<?php 

namespace app\controllers;

use app\models\SeatType;
use app\dao\lists\SeatTypeDAO as List_SeatTypeDAO;
use app\dao\db\SeatTypeDAO as DB_SeatTypeDAO;


class SeatTypes extends \app\controllers\Authentication {

	private $dao;

	public function __construct() {
        $this->requireAdminLogin();
		$this->dao = new DB_SeatTypeDAO();
	}

    public function index() {        
        $seatTypeArray = $this->dao->retrieveAll(); 
        require ADMIN_VIEWS . '/adminseattype.php';
    }

	public function add($type) {
		$seatType = new SeatType(null, $type);
		$this->dao->create($seatType);
		$this->index();
	}

	public function getAll() {
		return $this->dao->retrieveAll();
	}

	public function get($id) {
		 return $seattype=$this->dao->retrieveById($id);		
	}

	public function edit($id) {
		$seattype=$this->dao->retrieveById($id);

		if(isset($seattype)){
			require ADMIN_VIEWS . '/adminseattype.php';
		}
	}

	public function update($id, $newType) {
		$updatedSeatType = new SeatType($id, $newType);
		$this->dao->update($updatedSeatType);
		$this->index();
	}
    
    public function delete($id) {
        $this->dao->delete($id);
        $this->index();
    }
}

?>