<?php

namespace app\dao\db;

use \Exception;
use app\dao\IDAO;
use app\models\Category;    
use app\dao\db\Connection;

class CategoryDAO implements IDAO
{
    private $connection;
    private $tableName = "categories";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }    

    public function create($category) {
        try {
            $query = "INSERT INTO ".$this->tableName." (type) VALUES (:type);";
            $parameters["type"] = $category['type'];
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
        $parameters["id_category"] = $category['id_category'];
        $parameters["type"] = $category['type'];
        $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>