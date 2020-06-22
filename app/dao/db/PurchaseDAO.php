<?php

namespace app\dao\db;

use app\dao\IDAO;
use app\dao\db\Connection;
use app\dao\db\PurchaseLineDAO;
use app\models\Purchase;

class PurchaseDAO implements IDAO
{
    private $tableName = "purchases";
    private $connection;

    public function __construct()
    {   
        // Inicialización de carro de compra
        if (!isset($_SESSION['tptickets_items']) || !isset($_SESSION['tptickets_subtotal'])) {
            $_SESSION['tptickets_items']    = [];
            $_SESSION['tptickets_subtotal'] = 0;
        }

        $this->connection = Connection::getInstance();
    }

    // Shopping cart actions

    public function addNewLineInSession($data)
    {
        $subtotal = $data['price'] * $data['amount'];

        $_SESSION['tptickets_items'][] = [
            'id_event_seat' => $data['id_event_seat'],
            'amount'        => $data['amount'],
            'price'         => $data['price'],
            'subtotal'      => $subtotal,
            'event_name'    => $data['event_name'],
            'date'          => $data['date'],
        ];

        $_SESSION['tptickets_subtotal'] += $subtotal;

        return !empty($_SESSION['tptickets_items']) ? true : false;
    }

    public function removeLineInSession($id_event_seat)
    {
        $deleted = false;

        foreach ($_SESSION['tptickets_items'] as $key => $value) {

            if ($id_event_seat == $value['id_event_seat']) {
                $_SESSION['tptickets_subtotal'] -= $value['subtotal'];

                unset($_SESSION['tptickets_items'][$key]);

                $deleted = true;

                break;
            }
        }

        return $deleted;
    }

    public function removeAllLinesInSession()
    {
        $deleted = false;

        unset($_SESSION['tptickets_items']);

        if (!isset($_SESSION['tptickets_items'])) {
            $_SESSION['tptickets_subtotal'] = 0;

            $deleted = true;
        }

        return $deleted;
    }

    public function getAllLinesInSession()
    {
        return [
            'items'    => $_SESSION['tptickets_items'],
            'subtotal' => $_SESSION['tptickets_subtotal'],
        ];
    }

    // DB access
    
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id_client) VALUES (:id_client)";

            $parameters["id_client"] = $data['id_client'];  
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll()
    {
        try {
            $purchases = [];
            $purchase_line_arr = [];
            $purchase_line_dao = new PurchaseLineDAO();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $purchase_line_arr = $purchase_line_dao->retrieveByPurchaseId($row['id_purchase']);
                $purchase = new Purchase($row['id_purchase'], $row['id_client'], $row['date'], $purchase_line_arr);
                array_push($purchases, $purchase);
            }

            return $purchases;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id)
    {
        try {
            $purchase = null;
            $purchase_line_arr = [];
            $purchase_line_dao = new PurchaseLineDAO();            

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_purchase = :id_purchase";

            $parameters["id_purchase"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $purchase_line_arr = $purchase_line_dao->retrieveByPurchaseId($row['id_purchase']);
                $purchase = new Purchase($row['id_purchase'], $row['id_client'], $row['date'], $purchase_line_arr);
            }

            return $purchase;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_purchase = :id_purchase";

            $parameters["id_purchase"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET id_client = :id_client WHERE id_purchase = :id_purchase";

            $parameters['id_client'] = $data['id_client'];
            $parameters['id_purchase'] = $data['id_purchase'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
