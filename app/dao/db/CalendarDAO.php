<?php
namespace app\dao\db;
use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\Artist as Artist;
use app\models\Calendar as Calendar;    
use app\dao\db\Connection as Connection;
use app\dao\db\EventDao as EventDao;
use app\dao\db\PlaceEventDAO as PlaceEventDao;
use app\dao\db\EventSeatDAO as EventSeatDao;
use app\dao\db\ArtistDAO as ArtistDAO;

class CalendarDAO implements IDAO
{
    private $connection;
    private $tableName = "calendars";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    public function create($calendarAttributes) {
        try {
            $query = "INSERT INTO ".$this->tableName." (date, id_event) VALUES (:date, :id_event);";
            $parameters["date"] = $calendarAttributes["date"];
            $parameters["id_event"] = $calendarAttributes["eventId"];
            $this->connection->executeNonQuery($query, $parameters);
            $this->createArtistXCalendarRows($this->retrieveLastId(), $calendarAttributes["artistIdArray"]);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveLastId()
    {
        try {
            $calendarId= null;
            $query= "SELECT id_calendar FROM ". $this->tableName. " ORDER BY id_calendar DESC LIMIT 1;";
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
            $eventDao = new EventDAO();
            $placeEventDao = new PlaceEventDAO();
            $eventSeatDao = new EventSeatDAO();
            $artistDao = new ArtistDAO();
            $query = "SELECT * FROM " . $this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {       
                $event = $eventDao->retrieveById($row["id_event"]);     
                $placeEvent = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeatArray = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray = $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendar = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray,$placeEvent, $eventSeatArray[0]);
                array_push($calendarList, $calendar);
            }
            return $calendarList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    //CORREGIR
    public function retrieveById($id) {
        try {
            $calendar = null;
            $eventDao = new EventDAO();
            $placeEventDao = new PlaceEventDAO();
            $eventSeatDao = new EventSeatDAO();
            $artistDao = new ArtistDAO();            
            $query = "SELECT * FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $event = $eventDao->retrieveById($row["id_event"]);     
                $placeEvent = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeat = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray= $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendar = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeat[0]);
            }
            return $calendar;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByEventId($eventId) {
        try {
            $calendar = null;
            $eventDao = new EventDAO();
            $placeEventDao = new PlaceEventDAO();
            $eventSeatDao = new EventSeatDAO();
            $artistDao = new ArtistDAO();
            $query=  "SELECT * FROM ".$this->tableName." WHERE id_event = :id_event";
            $parameters["id_event"] = $eventId;
            $resultSet= $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $event = $eventDao->retrieveById($row["id_event"]);     
                $placeEvent = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeat = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray= $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendar = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeat[0]);               
            }
            return $calendar;
        } 
        catch(Exception $ex) {
            throw $ex;
        }
    }

    //CORREGIR
    public function retrieveCalendarsByString($string) {
        try {
            $calendarList = array();
            $eventDao = new EventDAO();
            $eventList = $eventDao->retrieveByString($string);
            $query = "SELECT * FROM ".$this->tableName." WHERE id_event = :id_event";
            foreach ($eventList as $value) {
                $parameters["id_event"] = $value->getId();
                $resultSet =$this->connection->execute($query, $parameters);
                foreach ($resultSet as $row) {
                    array_push($calendarList, $this->retrieveByEventId($parameters["id_event"]));
                }
            }
            return $calendarList;
        } 
        catch(Exception $ex) {
            throw $ex;
        }  
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

 
    public function deleteArtistXCalendarByCalendarId($calendarId) {
        try {
            $query = "DELETE FROM artists_calendars WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }
    public function update($calendarAttributes) {
        try {
            $this->deleteArtistXCalendarByCalendarId($calendarAttributes['id_calendar']);
            $query = "UPDATE ".$this->tableName." SET date = :date, id_event = :id_event WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarAttributes['id_calendar'];
            $parameters["date"] = $calendarAttributes['date'];
            $parameters["id_event"] = $calendarAttributes['eventId'];
            $this->connection->executeNonQuery($query, $parameters); 
            $this->createArtistXCalendarRows($calendarAttributes['id_calendar'], $calendarAttributes["artistIdArray"]);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function createArtistXCalendarRows($calendarId, $artistIdArray) {
        try {
            $query = "INSERT INTO artists_calendars (id_calendar, id_artist) VALUES (:id_calendar, :id_artist);";
            foreach ($artistIdArray as $value) {
                $parameters["id_calendar"] = $calendarId;
                $parameters["id_artist"] = $value;
                $this->connection->executeNonQuery($query, $parameters);
            }
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveArtistXCalendarByArtistId($calendarId) {
        try {
            $artistXcalendar= null;
            $query = "SELECT id_artist FROM artists_calendars WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $artistDao = new ArtistDAO();
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $artist = $artistDao->retrieveById($row['id_artist']);
                array_push($artists_calendar_array, $artist);
            }
            return $artists_calendar_array;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveArtistsByCalendarId($calendarId) {
        try {
            $artists_calendar_array = array();
            $artistDao = new ArtistDAO();
            $query = "SELECT * FROM artists_calendars WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $artist = $artistDao->retrieveById($row['id_artist']);
                array_push($artists_calendar_array, $artist);
            }
            return $artists_calendar_array;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>
