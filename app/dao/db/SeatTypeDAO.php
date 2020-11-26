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

    /**
     * Crea y da de alta un tipo de asiento.
     * @param  array $data El arreglo con las propiedades del tipo de asiento a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (description) VALUES (:description);";

            $parameters["description"] = $data['description'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la lista de los tipos de asientos.
     * @return array El arreglo de tipos de asientos
     */
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
    
    /**
     * Obtiene el tipo de asiento por id.
     * @param  int $id El id del tipo de asiento a buscar.
     * @return SeatType el objeto de tipo SeatType
     */
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
    
    /**
     * Elimina un tipo de asiento por id
     * @param  int $id El id del tipo de asiento a eliminar
     * @return void
     */
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

    /**
     * Actualiza los datos del tipo de asiento.
     * @param  array $data El arreglo con las propiedades del tipo de asiento a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET description = :description WHERE id_seat_type = :id_seat_type";

            $parameters["id_seat_type"] = $data['id_seat_type'];
            $parameters["description"]  = $data['description'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
