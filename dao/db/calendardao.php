<?php
namespace dao\db;
use config\Singleton as Singleton;
use \Exception as Exception;
use dao\IDAO as IDAO;
use model\Calendar as Calendar;    
use dao\db\Connection as Connection;
use dao\db\EventDao as EventDao;
use dao\db\PlaceEventDao as PlaceEventDao;
use dao\db\EventSeatDao as EventSeatDao;
use dao\db\ArtistDAO as ArtistDAO;
use model\Artist as Artist;

class CalendarDAO extends Singleton implements IDAO
{
    private $connection;
    private $tableName = "calendars";

    public function create($calendarAttributes) {
        try {
            $query = "INSERT INTO ".$this->tableName." (date, id_event) VALUES (:date, :id_event);";

            $parameters["date"] = $calendarAttributes["date"];
            $parameters["id_event"] = $calendarAttributes["eventId"];
        
            $this->connection = Connection::getInstance();

            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveLastId()
    {
        try{
            $calendarId= null;
            $query= "SELECT id_calendar FROM ". $this->tableName. " ORDER BY id_calendar DESC LIMIT 1;";
            $this->connection = Connection::getInstance();
            $resultSet= $this->connection->execute($query);  

            foreach ($resultSet as $row) {
                $calendarId= $row["id_calendar"];
            }

            
            return $calendarId;
        }
        catch(Exception $ex){
             throw $ex;
        }

    }

    public function retrieveAll() {
        try {
            $calendarList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);

            $eventDao = EventDao::getInstance();
            $placeEventDao = PlaceEventDao::getInstance();
            $eventSeatDao = EventSeatDAO::getInstance();
            $artistDao = ArtistDAO::getInstance();

            foreach ($resultSet as $row) {       
                $event = $eventDao->retrieveById($row["id_calendar"]);     
                $placeEvent = $placeEventDao->retrieveByCalendarId($row["id_calendar"]); 
                $eventSeat = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $calendar = new Calendar($row["id_calendar"], $row["date"],$event, new Artist(10, "Un Artista"), $placeEvent, $eventSeat);
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
                $calendar = new Calendar($row["id_calendar"], $row["date"], $row["id_event"], $row["artists"], $row["id_place_event"],  $row["id_seat_type"]);
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
            $query = "UPDATE ".$this->tableName." SET date = :date, id_event = :id_event, artists = :artists, id_place_event = :id_place_event, id_seat_type = :id_seat_type WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendar->getId();
            $parameters["date"] = $calendar->getDate();
            $parameters["id_event"] = $calendar->getEvent()->getId();
            $parameters["artists"] = $calendar->getArtistArray();
            $parameters["id_place_event"] = $calendar->getPlaceEvent()->getId();
            $parameters["id_seat_type"] = $calendar->getSeatType()->getId();

            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }

    public function retrieveEventsByString($string) {
        try {
            $calendar = null;
            $resultSet = array();
            $eventDao = new EventDAO();
            $eventList = $eventDao->retrieveByString($string);

            $query = "SELECT * FROM ".$this->tableName." WHERE id_event = :id_event";
            $this->connection = Connection::getInstance();

            foreach ($eventList as $value) {
                $parameters["id_event"] = $value->getId();
                array_push($this->connection->execute($query, $parameters), $resultSet);
            }


            foreach ($resultSet as $row) {
                $calendar = new Calendar($row["id_calendar"], $row["date"], $row["id_event"], $row["artists"], $row["id_place_event"],  $row["id_seat_type"]);
            }

            return $calendar;

        } catch(Exception $ex) {

        }  
    }


}
?>