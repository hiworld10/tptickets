<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\PlaceEvent;
use \Exception;

class PlaceEventDAO implements IDAO
{
    private $connection;
    private $tableName = "places_events";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un lugar de evento.
     * @param  array $data El arreglo con las propiedades del lugar de evento a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id_calendar, capacity, description) VALUES ( :id_calendar, :capacity, :description);";

            $parameters["id_calendar"] = $data["id_calendar"];
            $parameters["capacity"]    = $data["capacity"];
            $parameters["description"] = $data["description"];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la lista de los lugares de eventos.
     * @return array El arreglo de lugares de eventos
     */
    public function retrieveAll()
    {
        try {
            $placeEventList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $place_event = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
                array_push($placeEventList, $place_event);
            }

            return $placeEventList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene el lugar de evento por id.
     * @param  int $id El id del lugar de evento a buscar.
     * @return PlaceEvent el objeto de tipo PlaceEvent
     */
    public function retrieveById($id)
    {
        try {
            $place_event = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_place_event = :id_place_event";

            $parameters["id_place_event"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $place_event = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
            }

            return $place_event;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene el lugar de evento por id de calendario
     * @param  int $calendarId El id de calendario
     * @return PlaceEvent el objeto de tipo PlaceEvent
     */
    public function retrieveByCalendarId($calendarId)
    {
        try {
            $place_event = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendarId;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $place_event = new PlaceEvent($row["id_place_event"], $row["id_calendar"], $row["capacity"], $row["description"]);
            }

            return $place_event;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Elimina un lugar de evento por id
     * @param  int $id El id del lugar de evento a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_place_event = :id_place_event";

            $parameters["id_place_event"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del lugar de evento.
     * @param  array $data El arreglo con las propiedades del lugar de evento a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET capacity = :capacity, description = :description WHERE id_place_event = :id_place_event";

            $parameters["id_place_event"] = $data['id_place_event'];
            $parameters["capacity"]       = $data['capacity'];
            $parameters["description"]    = $data['description'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
