<?php

namespace app\dao\db;

use app\dao\IDAO;
use app\dao\db\Connection;
use app\dao\db\TicketDAO;
use app\models\PurchaseLine;

class PurchaseLineDAO implements IDAO
{
    private $tableName = "purchases_lines";
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta una línea de compra.
     * @param  array $data El arreglo con las propiedades de la línea de compra a crear
     * @return void
     */
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
    
    /**
     * Obtiene la lista de las líneas de compra.
     * @return array El arreglo de línea de compras
     */
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
    
    /**
     * Obtiene la línea de compra por id.
     * @param  int $id El id de la línea de compra a buscar.
     * @return PurchaseLine el objeto de tipo PurchaseLine
     */
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

    /**
     * Obtiene las líneas de compra asociadas a un id de compra
     * @param  int $id_purchase El id de compra
     * @return array El arreglo de líneas de compra
     */
    public function retrieveByPurchaseId($id_purchase)
    {
        try {
            $purchase_lines = [];
            $ticket_dao = new TicketDAO();

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_purchase = :id_purchase";

            $parameters["id_purchase"] = $id_purchase;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $ticket = $ticket_dao->retrieveByPurchaseLineId($row['id_purchase_line']);
                $purchase_lines[] = new PurchaseLine($row['id_purchase_line'], $row['id_event_seat'], $row['id_purchase'], $row['quantity'], $row['price'], $ticket);
            }

            return $purchase_lines;
        } catch (Exception $ex) {
            throw $ex;
        }
    }    

    /**
     * Obtiene el id de la última línea de compra en el sistema.
     * @return int El id de la última línea de commpra
     */
    public function retrieveLastId()
    {
        try {
            $id_purchase_line = null;          

            $query = "SELECT id_purchase_line FROM " . $this->tableName . " ORDER BY id_purchase_line DESC LIMIT 1";

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $id_purchase_line = $row['id_purchase_line'];
            }

            return $id_purchase_line;
        } catch (Exception $ex) {
            throw $ex;
        }        
    }

    /**
     * Elimina una línea de compra por id
     * @param  int $id El id de la línea de compra a eliminar
     * @return void
     */
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

    /**
     * Actualiza los datos de la línea de compra.
     * @param  array $data El arreglo con las propiedades de la línea de compra a actualizar 
     * @return void
     */
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
