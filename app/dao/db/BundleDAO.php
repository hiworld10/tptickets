<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\Bundle;
use \Exception;

class BundleDAO implements IDAO
{
    private $connection;
    private $tableName = "bundles";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un paquete.
     * @param  array $data El arreglo con las propiedades del paquete a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (description, discount) VALUES (:description, :discount)";

            $this->connection->executeNonQuery($query, $data);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene la lista de los paquetes.
     * @return array El arreglo de paquetes
     */
    public function retrieveAll()
    {
        try {
            $bundleList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $bundle = new Bundle($row["id_bundle"], $row["description"], $row['discount']);
                array_push($bundleList, $bundle);
            }

            return $bundleList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene el paquete por id.
     * @param  int $id El id del paquete a buscar.
     * @return Bundle el objeto de tipo Bundle
     */
    public function retrieveById($id)
    {
        try {
            $bundle = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_bundle = :id_bundle";

            $parameters["id_bundle"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $bundle = new Bundle($row["id_bundle"], $row["description"], $row['discount']);
            }

            return $bundle;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Elimina un paquete por id
     * @param  int $id El id del paquete a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_bundle = :id_bundle";

            $parameters["id_bundle"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del paquete.
     * @param  array $data El arreglo con las propiedades del paquete a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET description = :description, discount = :discount WHERE id_bundle = :id_bundle";

            $this->connection->executeNonQuery($query, $data);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
