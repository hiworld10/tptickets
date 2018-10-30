<?php
namespace dao\db;

use \Exception as Exception;
use dao\IDAO as IDAO;
use model\Calendar as Calendar;    
use dao\db\Connection as Connection;

class CalendarDAO implements IDAO
{
    private $connection;
    private $tableName = "calendars";

    public function create($calendar) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_calendar, date, id_event) VALUES (:id_calendar, :date, :id_event);";

            $parameters["id_calendar"] = $calendar->getId();
            $parameters["date"] = $calendar->getDate();
            $parameters["id_event"] = $calendar->getEventId();

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

            foreach ($resultSet as $row) {                
                $calendar = new Calendar($row["id_calendar"], $row["date"], $row["id_event"]);
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
            $event = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $id;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $calendar = new Calendar($row["id_calendar"], $row["date"], $row["id_event"]);
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
            $query = "UPDATE ".$this->tableName." SET date = :date, id_event = :id_event WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendar->getId();
            $parameters["date"] = $event->getDate();
            $parameters["id_event"] = $event->getEventId();

            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }
}
?>