<?php
namespace dao\db;

use \Exception as Exception;
use dao\IDAO as IDAO;
use model\PlaceEvent as PlaceEvent;    
use dao\db\Connection as Connection;

class CalendarDAO implements IDAO
{
    private $connection;
    private $tableName = "places_events";

    public function create($place_event) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_place_event, id_calendar, capacity, description) VALUES (:id_place_event, :id_calendar, :capacity, :description);";

            $parameters["id_place_event"] = $place_event->getIdPlaceEvent();
            $parameters["id_calendar"] = $place_event->getCalendarId();
            $parameters["capacity"] = $place_event->getCapacity();
            $parameters["description"] = $description->getDescription();

            $this->connection = Connection::getInstance();

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

            $this->connection = Connection::getInstance();

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

            $this->connection = Connection::getInstance();

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
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($place_event) {
        try {
            $query = "UPDATE ".$this->tableName." SET id_calendar = :id_calendar, capacity = :capacity, description = :description WHERE id_place_event = :id_place_event";
            $parameters["id_place_event"] = $place_event->getId();
            $parameters["id_calendar"] = $place_event->getCalendarId();
            $parameters["capacity"] = $place_event->getCapacity();
            $parameters["description"] = $place_event->getDescription();

            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }
}
?>