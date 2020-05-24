<?php 

namespace app\controllers;

use app\models\Category;
use app\dao\lists\CategoryDAO as List_CategoryDAO;
use app\dao\db\CategoryDAO as DB_CategoryDAO;


class Categories {

	private $dao;

	public function __construct() {
		$this->dao = new DB_CategoryDAO();
	}

	public function index() {
		
		$categoryArray = $this->dao->retrieveAll(); 
		require ADMIN_VIEWS . '/admincategory.php';
	}

    public function add($type) {

        $category = new Category(null, $type);
        $this->dao->create($category);
        $this->index();
    }

	public function getAll() {
		return $this->dao->retrieveAll();
	}
	
    public function get($id) {
        return $this->dao->retrieveById($id);
    }

	public function delete($id) {

		$this->dao->delete($id);
		$this->index();
	}

	public function edit($id) {
		$category=$this->dao->retrieveById($id);		
		if(isset($category)) {
			require ADMIN_VIEWS . '/admincategory.php';
		}
	}

	public function update($id, $newType) {
		$updatedCategory = new Category($id, $newType);
		$this->dao->update($updatedCategory);
		$this->index();
	}
}
?>
