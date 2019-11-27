<?php 
namespace controllers;

use model\Category as M_Category;
use dao\lists\CategoryDAO as List_CategoryDAO;
use dao\db\CategoryDAO as DB_CategoryDAO;


class CategoryController {

	private $dao;

	public function __construct() {
		$this->dao = new DB_CategoryDAO();
	}

	public function addCategory($type) {

		$m_category = new M_Category(null, $type);
		$this->dao->create($m_category);
		$this->getAll();
	}

	public function getAll() {
		
		$categoryArray = $this->dao->retrieveAll(); 
		require ADMIN_VIEWS . '/admincategory.php';
	}

	public function getAllSelect() {
		return $this->dao->retrieveAll();
	}
	

	public function deleteCategory($id) {

		$this->dao->delete($id);
		$this->getAll();
	}


	public function getCategory($id) {
		$category=$this->dao->retrieveById($id);		
		if(isset($category)) {
			require ADMIN_VIEWS . '/admincategory.php';
		}
	}

		public function getCategorySelect($id) {
		return $this->dao->retrieveById($id);
	}


	public function updateCategory($id, $newType) {
		$updatedCategory = new M_Category($id, $newType);
		$this->dao->update($updatedCategory);
		$this->getAll();
	}
}
?>
