<?php
namespace app\dao\db;


use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\Category as Category;    
use app\dao\db\Connection as Connection;

class CategoryDAO implements IDAO
{
    private $connection;
    private $tableName = "categories";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }    

    public function create($category) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_category, type) VALUES (:id_category, :type);";
            $parameters["id_category"] = $category->getId();
            $parameters["type"] = $category->getType();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $categoryList = array();
            $query = "SELECT * FROM ".$this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {                
                $category = new Category($row["id_category"], $row["type"]);
                array_push($categoryList, $category);
            }
            return $categoryList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $category = null;
            $query = "SELECT * FROM ".$this->tableName." WHERE id_category = :id_category";
            $parameters["id_category"] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $category = new Category($row["id_category"], $row["type"]);
            }
            return $category;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_category = :id_category";
            $parameters["id_category"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($category) {
       try {
        $query = "UPDATE ".$this->tableName." SET type = :type WHERE id_category = :id_category";
        $parameters["id_category"] = $category->getId();
        $parameters["type"] = $category->getType();
        $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>