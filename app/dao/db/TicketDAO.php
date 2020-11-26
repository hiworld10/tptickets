<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\Ticket;
use Endroid\QrCode\QrCode;
use \Exception;

class TicketDAO implements IDAO
{
    private $connection;
    private $tableName = "tickets";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un ticket.
     * @param  array $data El arreglo con las propiedades del ticket a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id_purchase_line, number) VALUES (:id_purchase_line, :number)";

            $parameters["id_purchase_line"] = $data['id_purchase_line'];
            $parameters["number"]           = $data['number'];

            $this->connection->executeNonQuery($query, $parameters);

            // Actualiza el contenido del qr añadiendo el id del ticket reciéntemente creado
            $this->updateQr($this->retrieveLastId(), $data['qr']);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la lista de los tickets.
     * @return array El arreglo de tickets
     */
    public function retrieveAll()
    {
        try {
            $ticketList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $qr = new QrCode($row['qr']);
                $qr->setSize(150);
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $qr);
                array_push($ticketList, $ticket);
            }

            return $ticketList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene el ticket por id.
     * @param  int $id El id del ticket a buscar.
     * @return Ticket el objeto de tipo Ticket
     */
    public function retrieveById($id)
    {
        try {
            $ticket = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_ticket = :id_ticket";

            $parameters['id_ticket'] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $qr = new QrCode($row['qr']);
                $qr->setSize(150);
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $qr);
            }

            return $ticket;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByPurchaseLineId($id)
    {
        try {
            $ticket = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_purchase_line = :id_purchase_line";

            $parameters['id_purchase_line'] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $qr = new QrCode($row['qr']);
                $qr->setSize(150);
                $ticket = new Ticket($row["id_ticket"], $row["id_purchase_line"], $row["number"], $qr);
            }

            return $ticket;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveLastId()
    {
        try {
            $id_ticket = null;

            $query = "SELECT id_ticket FROM " . $this->tableName . " ORDER BY id_ticket DESC LIMIT 1";

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $id_ticket = $row['id_ticket'];
            }

            return $id_ticket;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Elimina un ticket por id
     * @param  int $id El id del ticket a eliminar
     * @return void
     */
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

    /**
     * Actualiza los datos del ticket.
     * @param  array $data El arreglo con las propiedades del ticket a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET number = :number, qr = :qr, id_purchase_line = :id_purchase_line WHERE id_ticket = :id_ticket";

            $parameters["id_ticket"]        = $data['id_ticket'];
            $parameters["id_purchase_line"] = $data['id_purchase_line'];
            $parameters["number"]           = $data['number'];
            $parameters["qr"]               = $data['qr'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateQr($id_ticket, $qr)
    {
        try {

            $qr .= $id_ticket;

            $query = "UPDATE " . $this->tableName . " SET qr = :qr WHERE id_ticket = :id_ticket";

            $parameters["id_ticket"] = $id_ticket;
            $parameters["qr"]        = $qr;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
