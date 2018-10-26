<?php 
namespace controllers;

use model\Category as M_Category;
use dao\lists\CategoryDAO as CategoryDAO;


class CategoryController {

	private $dao;

	public function __construct() {
		$this->dao = new CategoryDAO();
	}

	public function addCategory($type) {

		$m_category = new M_Category(null, $type);
		$this->dao->create($m_category);
		$this->getAll();


	}

	public function getAll(){
		$categoryArray = $this->dao->retrieveAll(); 
		include ADMIN_VIEWS . '/admincategory.php';
	}

	public function deleteCategory($id){

		$this->dao->delete($id);
		$this->getAll();
	}


	public function getCategory($id){
		$category=$this->dao->retrieveById($id);		
		if(isset($category)){
			include ADMIN_VIEWS . '/admincategory.php';
		}
	}


	public function updateCategory($id, $newType) {
		$updatedCategory = new M_Category($id, $newType);
		print_r($updatedCategory);
		$this->dao->update($updatedCategory);
		$this->getAll();
	}

}

?>