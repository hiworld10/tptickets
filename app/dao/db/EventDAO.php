<?php
namespace app\dao\db;


use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\Event as Event;    
use app\models\Photo as Photo;
use app\dao\db\Connection as Connection;
use app\dao\db\CategoryDAO as CategoryDAO;

class EventDAO implements IDAO
{
    private $connection;
    private $tableName = "events";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    public function create($event) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_event, name, id_category, image) VALUES (:id_event, :name, :id_category, :image);";
            $parameters["id_event"] = $event->getId();
            $parameters["name"] = $event->getName();
            $parameters["id_category"] = $event->getCategory()->getId();
            $parameters["image"] = $event->getImage()->getPath();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $eventList = array();
            $categoryDAO = new CategoryDAO();
            $query = "SELECT * FROM ".$this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {
                $category = $categoryDAO->retrieveById($row["id_category"]);
                $photo= new Photo();
                $photo->setPath($row['image']);        
                $event = new Event($row["id_event"], $row["name"], $category, $photo);
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $event = null;
            $categoryDAO = new CategoryDAO();
            $query = "SELECT * FROM ".$this->tableName." WHERE id_event = :id_event";
            $parameters["id_event"] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $category = $categoryDAO->retrieveById($row["id_category"]);
                $photo= new Photo();
                $photo->setPath($row['image']);
                $event = new Event($row["id_event"], $row["name"], $category, $photo);
            }
            return $event;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_event = :id_event";
            $parameters["id_event"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($event) {
        try {
            $query = "UPDATE ".$this->tableName." SET name = :name, id_category = :id_category, image = :image WHERE id_event = :id_event";
            $parameters["id_event"] = $event->getId();
            $parameters["name"] = $event->getName();
            $parameters["id_category"] = $event->getCategory()->getId();
            $parameters["image"]= $event->getImage()->getPath();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }

    public function retrieveByString($string) {
        try {
            $eventList = array();
            $categoryDAO = new CategoryDAO();
            $query = "SELECT * FROM ".$this->tableName." WHERE name LIKE '%".$string."%';";
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {
                $category = $categoryDAO->retrieveById($row["id_category"]);
                $photo= new Photo();
                $photo->setPath($row['image']);
                $event = new Event($row["id_event"], $row["name"], $category, $photo);
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>