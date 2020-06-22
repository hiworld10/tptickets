<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\Ticket;
use \Exception;

class TicketDAO implements IDAO
{
    private $connection;
    private $tableName = "tickets";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function create($ticket)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id_purchase_line, number, qr) VALUES (:id_purchase_line, :number, :qr);";

            $parameters["id_purchase_line"] = $ticket->getPurchaseLineId();
            $parameters["number"]           = $ticket->getNumber();
            $parameters["qr"]               = $ticket->getQr();

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll()
    {
        try {
            $ticketList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $row["qr"]);
                array_push($ticketList, $ticket);
            }

            return $ticketList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id)
    {
        try {
            $ticket = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_ticket = :id_ticket";

            $parameters["id_ticket"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $row["qr"]);
            }

            return $ticket;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByNumber($number)
    {
        try {
            $ticket = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE number = :number";

            $parameters["number"] = $number;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $row["qr"]);
            }

            return $ticket;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_ticket = :id_ticket";

            $parameters["id_ticket"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($ticket)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET number = :number, qr = :qr, id_purchase_line = :id_purchase_line WHERE id_ticket = :id_ticket";

            $parameters["id_purchase_line"] = $ticket->getPurchaseLineId();
            $parameters["number"]           = $ticket->getNumber();
            $parameters["qr"]               = $ticket->getQr();

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
