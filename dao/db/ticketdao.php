<?php
namespace dao\db;

use \Exception as Exception;
use dao\IDAO as IDAO;
use model\Ticket as Ticket;    
use dao\db\Connection as Connection;

class TicketDAO implements IDAO
{
    private $connection;
    private $tableName = "tickets";

    public function create($ticket) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_ticket, id_purchase_line, number, qr) VALUES (:id_ticket, :id_purchase_line, :number, :qr);";

            $parameters["id_ticket"] = $ticket->getId();
            $parameters["id_purchase_line"] = $ticket->getPurchaseLineId();
            $parameters["number"] = $ticket->getNumber();
            $parameters["qr"] = $ticket->getQr();

            $this->connection = Connection::getInstance();

            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $ticketList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {                
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $row["qr"]);

                array_push($ticketList, $ticket);
            }

            return $ticketList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $ticket = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE id_ticket = :id_ticket";

            $parameters["id_ticket"] = $id;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $row["qr"]);
            }

            return $ticket;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByNumber($number) {
        try {
            $ticket = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE number = :number";

            $parameters["number"] = $number;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $row["qr"]);

            }

            return $ticket;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }



    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_ticket = :id_ticket";
            $parameters["id_ticket"] = $id;
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($ticket) {
        try {
            $query = "UPDATE ".$this->tableName." SET number = :number, qr = :qr, id_purchase_line = :id_purchase_line WHERE id_ticket = :id_ticket";
            $parameters["id_ticket"] = $ticket->getId();
            $parameters["id_purchase_line"] = $ticket->getPurchaseLineId();
            $parameters["number"] = $ticket->getNumber();
            $parameters["qr"] = $ticket->getQr();


            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>