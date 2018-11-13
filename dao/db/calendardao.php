<?php
namespace dao\db;

use \Exception as Exception;
use dao\IDAO as IDAO;
use model\Calendar as Calendar;    
use dao\db\Connection as Connection;
use dao\db\EventDao as EventDao;
use dao\db\PlaceEventDao as PlaceEventDao;

class CalendarDAO implements IDAO
{
    private $connection;
    private $tableName = "calendars";

    public function create($calendar) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_calendar, date, id_event, artists, id_place_event) VALUES (:id_calendar, :date, :id_event, :artists, :id_place_event);";

            $parameters["id_calendar"] = $calendar->getId();
            $parameters["date"] = $calendar->getDate();
            $parameters["id_event"] = $calendar->getEvent()->getId();
            $parameters["artists"] = $calendar->getArtistArray();
            $parameters["id_place_event"] = $calendar->getPlaceEvent()->getId();

            $this->connection = Connection::getInstance();

            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $calendarList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);

            $eventDao= new EventDao();
            $placeEventDao= new PlaceEventDao();


            foreach ($resultSet as $row) {       
                $event=$eventDao->retrieveById($row["id_event"]);     
                $placeEvent=$placeEventDao->retrieveById($row["id_place_event"]);        
                $calendar = new Calendar($row["id_calendar"], $row["date"],$event, $row["artists"], $placeEvent);
                array_push($calendarList, $calendar);
            }

            return $calendarList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $calendar = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $id;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $calendar = new Calendar($row["id_calendar"], $row["date"], $row["id_event"], $row["artists"], $row["id_place_event"]);
            }

            return $calendar;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $id;
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($calendar) {
        try {
            $query = "UPDATE ".$this->tableName." SET date = :date, id_event = :id_event, artists = :artists, id_place_event = :id_place_event WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendar->getId();
            $parameters["date"] = $calendar->getDate();
            $parameters["id_event"] = $calendar->getEvent()->getId();
            $parameters["artists"] = $calendar->getArtistArray();
            $parameters["id_place_event"] = $calendar->getPlaceEvent()->getId();

            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }
}
?>