<?php  
	namespace app\dao;

interface IDAO{

	public function create($newVal);
	public function retrieveAll();
	public function retrieveById($id);
	public function update($newVal);
	public function delete($newVal);
}
?>