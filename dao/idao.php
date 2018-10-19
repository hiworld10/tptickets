<?php  
	namespace dao;

interface IDAO{

	public function create($newVal);
	public function retrieve();
	public function update($newVal);
	public function delete($newVal);
}
?>