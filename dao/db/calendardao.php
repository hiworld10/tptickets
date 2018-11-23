<?php
namespace dao\db;
use \Exception as Exception;
use dao\IDAO as IDAO;
use model\Calendar as Calendar;    
use dao\db\Connection as Connection;
use dao\db\EventDao as EventDao;
use dao\db\PlaceEventDao as PlaceEventDao;
use dao\db\EventSeatDao as EventSeatDao;
use dao\db\ArtistDAO as ArtistDAO;
use model\Artist as Artist;

class CalendarDAO implements IDAO
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

            $this->createArtistXCalendarRow($this->retrieveLastId(), $calendarAttributes["artistIdArray"]);


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

            $eventDao = new EventDao();
            $placeEventDao = new PlaceEventDao();
            $eventSeatDao = new EventSeatDAO();
            $artistDao = new ArtistDAO();

            foreach ($resultSet as $row) {       
                $event = $eventDao->retrieveById($row["id_event"]);     
                $placeEvent = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);                
                $eventSeatArray = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray= $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendar = new Calendar($row["id_calendar"], $row["date"], $event , $artistsArray , $placeEvent, $eventSeatArray[0] );
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

            $query = "SELECT * FROM ".$this->tableName." WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $id;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            $eventDao = new EventDao();
            $placeEventDao = new PlaceEventDao();
            $eventSeatDao = new EventSeatDAO();
            $artistDao = new ArtistDAO();



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

 
    public function update($calendarAttributes) {
        try {
            $query = "UPDATE ".$this->tableName." SET date = :date, id_event = :id_event WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendarAttributes['id'];
            $parameters["date"] = $calendarAttributes['date'];
            $parameters["id_event"] = $calendarAttributes['event'];
           

            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }

    //CORREGIR
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

    public function createArtistXCalendarRow($calendarId, $artistIdArray) {
        try {


            $query = "INSERT INTO artists_calendars (id_calendar, id_artist) VALUES (:id_calendar, :id_artist);";
        
            $this->connection = Connection::getInstance();

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



     public function retrieveArtistsByCalendarId($calendarId) {
        try {
            $artists_calendar_array = array();

            $query = "SELECT * FROM artists_calendars WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendarId;

            $artistDao = new ArtistDAO();

            $this->connection = Connection::getInstance();

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
