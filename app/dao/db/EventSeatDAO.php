<?php
namespace app\dao\db;


use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\EventSeat as EventSeat;    
use app\dao\db\Connection as Connection;
use app\dao\db\SeatTypeDAO as SeatTypeDAO;

class EventSeatDAO implements IDAO
{
    private $connection;
    private $tableName = "event_seats";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    public function create($eventSeat) {
        try {
            $query = "INSERT INTO ".$this->tableName." (quantity, price, id_calendar, id_seat_type, remainder) VALUES ( :quantity, :price, :id_calendar, :id_seat_type, :remainder );";
            $parameters["quantity"] = $eventSeat->getQuantity();
            $parameters["price"] = $eventSeat->getPrice();
            $parameters["id_calendar"] = $eventSeat->getCalendarId();
            $parameters["id_seat_type"] = $eventSeat->getSeatType()->getId();
            $parameters["remainder"] = $eventSeat->getRemainder();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $eventSeatList = array();
            $seatTypeDao= new SeatTypeDAO();
            $query = "SELECT * FROM ".$this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {
                $seatType=$seatTypeDao->retrieveById($row["id_seat_type"]);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seatType, $row["quantity"], $row["price"], $row["remainder"]);
                array_push($eventSeatList, $eventSeat);
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
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $event = new EventSeat($row["id_event_seat"], $row["id_calendar"], $row["id_seat_type"], $row["quantity"], $row["price"], $row["remainder"]);
            }
            return $eventSeat;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

        public function retrieveByCalendarId($calendarId) {
        try {
            $eventSeatArray = array();
            $seatTypeDao= new SeatTypeDAO();
            $query = "SELECT * FROM ".$this->tableName." WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $seatType=$seatTypeDao->retrieveById($row["id_seat_type"]);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seatType, $row["quantity"], $row["price"],$row["remainder"]);
                array_push($eventSeatArray, $eventSeat);
            }
            return $eventSeatArray;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }


    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_event = :id_event";
            $parameters["id_event_seat"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($eventSeat) {
        try {
        
            $query = "UPDATE ".$this->tableName." SET quantity = :quantity, price = :price, remainder = :remainder WHERE id_event_seat = :id_event_seat";
            $parameters["id_event_seat"] = $eventSeat->getId();
            $parameters["quantity"] = $eventSeat->getQuantity();
            $parameters["price"] = $eventSeat->getPrice();
            $parameters["remainder"] = $eventSeat->getRemainder();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>