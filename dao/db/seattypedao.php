<?php
namespace dao\db;

use \Exception as Exception;
use dao\IDAO as IDAO;
use model\Seattype as SeatType;    
use dao\db\Connection as Connection;

class SeatTypeDAO implements IDAO
{
    private $connection;
    private $tableName = "seat_type";

    public function create($seatType) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_seat_type, description) VALUES (:id_seat_type, :description);";

            $parameters["id_seat_type"] = $seatType->getId();
            $parameters["description"] = $seatType->getType();

            $this->connection = Connection::getInstance();

            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $seatTypeList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {                
                $seatType = new SeatType($row["id_seat_type"], $row["description"]);
                array_push($seatTypeList, $seatType);
            }

            return $seatTypeList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $seatType = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE id_seat_type = :id_seat_type";

            $parameters["id_seat_type"] = $id;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seatType = new SeatType($row["id_seat_type"], $row["description"]);
            }

            return $seatType;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByCalendarId($calendarId) {
        try {
            $seatType = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendarId;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seatType = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
            }

            return $seatType;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_seat_type = :id_seat_type";
            $parameters["id_seat_type"] = $id;
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($seatType) {
       try {
        $query = "UPDATE ".$this->tableName." SET description = :description WHERE id_seat_type = :id_seat_type";
        $parameters["id_seat_type"] = $seatType->getId();
        $parameters["description"] = $seatType->getType();
        $this->connection = Connection::getInstance();
        $this->connection->executeNonQuery($query, $parameters);   
    }
    catch(Exception $ex) {
        throw $ex;
    }

}
}
?>