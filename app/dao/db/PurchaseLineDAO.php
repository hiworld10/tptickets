<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\PurchaseLine;

class PurchaseLineDAO implements IDAO
{
    private $tableName = "purchases_lines";
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id_event_seat, id_purchase, quantity, price) VALUES (:id_event_seat, :id_purchase, :quantity, :price)";

            $parameters["id_event_seat"] = $data['id_event_seat'];
            $parameters["id_purchase"] = $data['id_purchase'];
            $parameters["quantity"] = $data['quantity'];
            $parameters["price"] = $data['price'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll()
    {
        try {
            $purchases = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $purchase_line = new PurchaseLine($row['id_purchase_line'], $row['id_event_seat'], $row['id_purchase'], $row['quantity'], $row['price'], null);
                array_push($purchases, $purchase_line);
            }

            return $purchases;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id)
    {
        try {
            $purchase_line = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_purchase_line = :id_purchase_line";

            $parameters["id_purchase_line"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $purchase_line = new PurchaseLine($row['id_purchase_line'], $row['id_event_seat'], $row['id_purchase'], $row['quantity'], $row['price'], null);
            }

            return $purchase_line;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_purchase_line = :id_purchase_line";

            $parameters["id_purchase_line"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET id_event_seat = :id_event_seat, id_purchase = :id_purchase, quantity = :quantity, price = :price WHERE id_purchase_line = :id_purchase_line";

            $parameters["id_purchase_line"] = $data['id_purchase_line'];
            $parameters["id_event_seat"] = $data['id_event_seat'];
            $parameters["id_purchase"] = $data['id_purchase'];
            $parameters["quantity"] = $data['quantity'];
            $parameters["price"] = $data['price'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
