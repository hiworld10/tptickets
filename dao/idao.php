<?php  
	namespace dao;

interface IDAO{

	public function create($newVal);
	public function retrieveAll();
	public function retrieveById($id);
	public function update($id, $newVal);
	public function delete($newVal);
}
?>