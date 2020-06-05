<?php
namespace app\dao\db;


use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\Event as Event;    
use app\models\Photo as Photo;
use app\dao\db\Connection as Connection;
use app\dao\db\CategoryDAO as CategoryDAO;
use app\dao\db\CalendarDAO;


class EventDAO implements IDAO
{
    private $connection;
    private $tableName = "events";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    public function create($event) {
        try {
            $query = "INSERT INTO ".$this->tableName." (name, id_category, image) VALUES (:name, :id_category, :image);";
            $parameters["name"] = $event['name'];
            $parameters["id_category"] = $event['id_category'];
            $parameters["image"] = $event['image'];
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

    public function retrieveAllActive() {

        try {
            $eventList = array();
            $id_event_array = array();           
            $query = "SELECT id_event FROM calendars";
            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $id_event_array[] = $row['id_event'];
            }

            $id_event_array = array_unique($id_event_array);
            
            foreach ($id_event_array as $id) {
                $eventList[] = $this->retrieveById($id);
            }

            return $eventList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveActiveEventsByString($string) {
        try {

            $events = $this->retrieveAllActive();

            $results = [];
            $categoryDAO = new CategoryDAO();

            $query = "SELECT * FROM events WHERE id_event = :id_event AND name LIKE '%" . $string . "%' ";

            foreach ($events as $event) {
                $parameters["id_event"] = $event->getId();
                $row = $this->connection->execute($query, $parameters);

                $resultSet = $this->connection->execute($query, $parameters);
                foreach ($resultSet as $row) {
                    $category = $categoryDAO->retrieveById($row["id_category"]);
                    $photo= new Photo();
                    $photo->setPath($row['image']);
                    $event = new Event($row["id_event"], $row["name"], $category, $photo);
                    $results[] = $event; 
                }
            }

            return $results;
                
        } catch (Exception $ex) {

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
            $parameters["id_event"] = $event['id_event'];
            $parameters["name"] = $event['name'];
            $parameters["id_category"] = $event['id_category'];
            $parameters["image"]= $event['image'];
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