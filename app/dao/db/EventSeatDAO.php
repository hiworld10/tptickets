<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\db\SeatTypeDAO;
use app\dao\IDAO;
use app\models\EventSeat;
use \Exception;

class EventSeatDAO implements IDAO
{
    private $connection;
    private $tableName = "event_seats";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un asiento de evento.
     * @param  array $data El arreglo con las propiedades del asiento de evento a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (quantity, price, id_calendar, id_seat_type, remainder) VALUES (:quantity, :price, :id_calendar, :id_seat_type, :remainder);";

            $parameters["quantity"]     = $data['quantity'];
            $parameters["price"]        = $data['price'];
            $parameters["id_calendar"]  = $data['id_calendar'];
            $parameters["id_seat_type"] = $data['id_seat_type'];
            $parameters["remainder"]    = $data['remainder'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la lista de los asientos de eventos.
     * @return array El arreglo de asientos de eventos
     */
    public function retrieveAll()
    {
        try {
            $eventSeatList = [];
            $seatTypeDao   = new SeatTypeDAO();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $seatType  = $seatTypeDao->retrieveById($row["id_seat_type"]);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seatType, $row["quantity"], $row["price"], $row["remainder"]);
                array_push($eventSeatList, $eventSeat);
            }

            return $eventSeatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene el asiento de evento por id.
     * @param  int $id El id del asiento de evento a buscar.
     * @return EventSeat el objeto de tipo EventSeat
     */
    public function retrieveById($id)
    {
        try {
            $eventSeat   = null;
            $seatTypeDao = new SeatTypeDAO;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_event_seat = :id_event_seat";

            $parameters["id_event_seat"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seat_type = $seatTypeDao->retrieveById($row['id_seat_type']);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seat_type, $row["quantity"], $row["price"], $row["remainder"]);
            }

            return $eventSeat;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene los asientos de evento asociados a un id de calendario específico
     * @param  id $calendarId El id de calendario
     * @return array             El arreglo de asientos de evento
     */
    public function retrieveByCalendarId($calendarId)
    {
        try {
            $eventSeatArray = [];
            $seatTypeDao    = new SeatTypeDAO();

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendarId;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $seatType  = $seatTypeDao->retrieveById($row["id_seat_type"]);
                $eventSeat = new EventSeat($row["id_event_seat"], $row["id_calendar"], $seatType, $row["quantity"], $row["price"], $row["remainder"]);
                array_push($eventSeatArray, $eventSeat);
            }

            return $eventSeatArray;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Elimina un asiento de evento por id
     * @param  int $id El id del asiento de evento a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_event = :id_event";

            $parameters["id_event_seat"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del asiento de evento.
     * @param  array $data El arreglo con las propiedades del asiento de evento a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET quantity = :quantity, price = :price, remainder = :remainder WHERE id_event_seat = :id_event_seat";

            $parameters["id_event_seat"] = $data['id_event_seat'];
            $parameters["quantity"]      = $data['quantity'];
            $parameters["price"]         = $data['price'];
            $parameters["remainder"]     = $data['remainder'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza el remanente del asiento de evento restándole la cantidad de asientos vendidos en una compra.
     * @param  int $id_event_seat El id del asiento de evento
     * @param  int $amount La cantidad a restar en el remanente
     * @return void
     */
    public function updateRemainder($id_event_seat, $amount)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET remainder = remainder - :amount WHERE id_event_seat = :id_event_seat";

            $parameters["id_event_seat"] = $id_event_seat;
            $parameters["amount"]        = $amount;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
