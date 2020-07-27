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

    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (description, discount) VALUES (:description, :discount)";

            $this->connection->executeNonQuery($query, $data);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

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
