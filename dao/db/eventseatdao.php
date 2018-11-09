<?php
namespace dao\db;

use \Exception as Exception;
use dao\IDAO as IDAO;
use model\EventSeat as EventSeat;    
use dao\db\Connection as Connection;

class EventSeatDAO implements IDAO
{
    private $connection;
    private $tableName = "event_seats";

    public function create($eventSeat) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_event_seat, quantity, price, id_calendar, id_seat_type) VALUES (:id_event_seat, :quantity, :price, :id_calendar, :id_seat_type );";

            $parameters["id_event_seat"] = $eventSeat->getId();
            $parameters["quantity"] = $eventSeat->getAvailableSeats();
            $parameters["price"] = $eventSeat->getPrice();
            $parameters["id_calendar"] = $eventSeat->getCalendarId();
            $parameters["id_seat_type"] = $eventSeat->getSeatTypeId();

            $this->connection = Connection::getInstance();

            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $eventSeatList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {                
                $event = new EventSeat($row["id_event_seat"], $row["quantity"], $row["price"], $row["id_calendar"], $row["id_seat_type"]);
                array_push($eventList, $eventSeat);

                print_r($event);
            }

            return $eventSeatList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $eventSeat = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE id_event = :id_event";

            $parameters["id_event_seat"] = $id;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $event = new EventSeat($row["id_event_seat"], $row["quantity"], $row["price"], $row["id_calendar"], $row["id_seat_type"]);
            }

            return $eventSeat;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_event = :id_event";
            $parameters["id_event_seat"] = $id;
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($eventSeat) {
        try {
            $query = "UPDATE ".$this->tableName." SET quantity = :quantity, price = :price, id_calendar = :id_calendar, id_seat_type = :id_seat_type WHERE id_event_seat = :id_event_seat";
            $parameters["id_event_seat"] = $eventSeat->getId();
            $parameters["quantity"] = $eventSeat->getAvailableSeats();
            $parameters["price"] = $eventSeat->getPrice();
            $parameters["id_calendar"] = $eventSeat->getCalendarId();
            $parameters["id_seat_type"] = $eventSeat->getSeatTypeId();

            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }
}
?>