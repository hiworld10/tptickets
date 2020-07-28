<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\SeatType;
use \Exception;

class SeatTypeDAO implements IDAO
{
    private $connection;
    private $tableName = "seat_types";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function create($seat_type)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (description) VALUES (:description);";

            $parameters["description"] = $seat_type['description'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll()
    {
        try {
            $seatTypeList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $seatType = new SeatType($row["id_seat_type"], $row["description"]);
                array_push($seatTypeList, $seatType);
            }

            return $seatTypeList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id)
    {
        try {
            $seatType = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_seat_type = :id_seat_type";

            $parameters["id_seat_type"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seatType = new SeatType($row["id_seat_type"], $row["description"]);
            }

            return $seatType;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_seat_type = :id_seat_type";

            $parameters["id_seat_type"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($seat_type)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET description = :description WHERE id_seat_type = :id_seat_type";

            $parameters["id_seat_type"] = $seat_type['id_seat_type'];
            $parameters["description"]  = $seat_type['description'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
