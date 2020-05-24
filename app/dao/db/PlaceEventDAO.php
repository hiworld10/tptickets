<?php
namespace app\dao\db;


use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\PlaceEvent as PlaceEvent;    
use app\dao\db\Connection as Connection;

class PlaceEventDAO  implements IDAO
{
    private $connection;
    private $tableName = "places_events";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    public function create($place_event) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_calendar, capacity, description) VALUES ( :id_calendar, :capacity, :description);";
            $parameters["id_calendar"] = $place_event->getCalendarId();
            $parameters["capacity"] = $place_event->getCapacity();
            $parameters["description"] = $place_event->getDescription();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $placeEventList = array();
            $query = "SELECT * FROM ".$this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {                
                $place_event = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
                array_push($placeEventList, $place_event);
            }
            return $placeEventList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $place_event = null;
            $query = "SELECT * FROM ".$this->tableName." WHERE id_place_event = :id_place_event";
            $parameters["id_place_event"] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $place_event = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
            }
            return $place_event;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByCalendarId($calendarId) {
        try {
            $place_event = null;
            $query = "SELECT * FROM ".$this->tableName." WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $place_event = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
            }
            return $place_event;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_place_event = :id_place_event";
            $parameters["id_place_event"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($place_event) {
        try {
            $query = "UPDATE ".$this->tableName." SET capacity = :capacity, description = :description WHERE id_place_event = :id_place_event";
            $parameters["id_place_event"] = $place_event->getId();
            $parameters["capacity"] = $place_event->getCapacity();
            $parameters["description"] = $place_event->getDescription();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>