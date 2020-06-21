<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\db\SeatTypeDAO;
use app\dao\IDAO;
use app\models\EventSeat;
use \Exception;

class EventSeatDAO implements IDAO
{
    private $connection;
    private $tableName = "event_seats";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function create($event_seat)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (quantity, price, id_calendar, id_seat_type, remainder) VALUES (:quantity, :price, :id_calendar, :id_seat_type, :remainder);";

            $parameters["quantity"]     = $event_seat['quantity'];
            $parameters["price"]        = $event_seat['price'];
            $parameters["id_calendar"]  = $event_seat['id_calendar'];
            $parameters["id_seat_type"] = $event_seat['id_seat_type'];
            $parameters["remainder"]    = $event_seat['remainder'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll()
    {
        try {
            $eventSeatList = [];
            $seatTypeDao   = new SeatTypeDAO();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $seatType  = $seatTypeDao->retrieveById($row["id_seat_type"]);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seatType, $row["quantity"], $row["price"], $row["remainder"]);
                array_push($eventSeatList, $eventSeat);
            }

            return $eventSeatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id)
    {
        try {
            $eventSeat   = null;
            $seatTypeDao = new SeatTypeDAO;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_event_seat = :id_event_seat";

            $parameters["id_event_seat"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seat_type = $seatTypeDao->retrieveById($row['id_seat_type']);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seat_type, $row["quantity"], $row["price"], $row["remainder"]);
            }

            return $eventSeat;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByCalendarId($calendarId)
    {
        try {
            $eventSeatArray = [];
            $seatTypeDao    = new SeatTypeDAO();

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendarId;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seatType  = $seatTypeDao->retrieveById($row["id_seat_type"]);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seatType, $row["quantity"], $row["price"], $row["remainder"]);
                array_push($eventSeatArray, $eventSeat);
            }

            return $eventSeatArray;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_event = :id_event";

            $parameters["id_event_seat"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($event_seat)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET quantity = :quantity, price = :price, remainder = :remainder WHERE id_event_seat = :id_event_seat";

            $parameters["id_event_seat"] = $event_seat['id_event_seat'];
            $parameters["quantity"]      = $event_seat['quantity'];
            $parameters["price"]         = $event_seat['price'];
            $parameters["remainder"]     = $event_seat['remainder'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
