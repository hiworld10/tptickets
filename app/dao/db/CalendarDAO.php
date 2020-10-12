<?php

namespace app\dao\db;

use app\dao\db\ArtistDAO;
use app\dao\db\Connection;
use app\dao\db\EventDAO;
use app\dao\db\EventSeatDAO;
use app\dao\db\PlaceEventDAO;
use app\dao\IDAO;
use app\models\Calendar;
use \Exception;

class CalendarDAO implements IDAO
{
    private $connection;
    private $tableName = "calendars";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un calendario.
     * @param  array $data El arreglo con las propiedades del calendario a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (date, id_event) VALUES (:date, :id_event);";

            $parameters["date"]     = $data["date"];
            $parameters["id_event"] = $data["id_event"];

            $this->connection->executeNonQuery($query, $parameters);

            if (isset($data['id_artist_arr'])) {
                $calendar_id = $this->retrieveLastId();
                $this->createArtistXCalendarRows($calendar_id, $data['id_artist_arr']);
            }

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Crea los registros de la tabla intermedia artist_calendar
     * @param  int $id_calendar   el id del calendario
     * @param  int $id_artist_arr el id del artista
     * @return void
     */
    public function createArtistXCalendarRows($id_calendar, $id_artist_arr)
    {
        try {
            $query = "INSERT INTO artists_calendars (id_calendar, id_artist) VALUES (:id_calendar, :id_artist);";

            foreach ($id_artist_arr as $value) {
                $parameters["id_calendar"] = $id_calendar;
                $parameters["id_artist"]   = $value;
                $this->connection->executeNonQuery($query, $parameters);
            }

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Elimina un calendario por id
     * @param  int $id El id del calendario a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $id;

            $this->connection->executeNonQuery($query, $parameters);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    /**
     * Elimina un registro de la tabla intermedia artist_calendar
     * @param  int $id_calendar el id del calendario
     * @param  int $id_artist   el id del artista
     * @return void
     */
    public function deleteArtistXCalendar($id_calendar, $id_artist)
    {
        try {
            $query = "DELETE FROM artists_calendars WHERE id_artist = :id_artist AND id_calendar = :id_calendar";

            $parameters["id_artist"]   = $id_artist;
            $parameters["id_calendar"] = $id_calendar;

            $this->connection->executeNonQuery($query, $parameters);

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene la lista de los calendarios.
     * @return array El arreglo de calendarios
     */
    public function retrieveAll()
    {
        try {
            $calendarList  = [];
            $eventDao      = new EventDAO();
            $placeEventDao = new PlaceEventDAO();
            $eventSeatDao  = new EventSeatDAO();
            $artistDao     = new ArtistDAO();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $event          = $eventDao->retrieveById($row["id_event"]);
                $placeEvent     = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeatArray = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray   = $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendar       = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeatArray);
                array_push($calendarList, $calendar);
            }

            return $calendarList;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene los registros de la tabla intermedia artists_calendars correspondientes al id de calendario, crea objetos de tipo Artist en base al id de los registros y los retorna. 
     * @param  int $calendar_id El id de calendario
     * @return array El arreglo de artistas
     */
    public function retrieveArtistsByCalendarId($calendar_id)
    {
        try {
            $artist_list = [];
            $artist_dao   = new ArtistDAO();

            $query = "SELECT * FROM artists_calendars WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $calendar_id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $artist = $artist_dao->retrieveById($row['id_artist']);
                array_push($artist_list, $artist);
            }

            return $artist_list;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene calendarios por id de evento.
     * @param  int $event_id El id del evento
     * @return array         El arreglo de calendarios
     */
    public function retrieveByEventId($event_id)
    {
        try {
            $calendars     = [];
            $eventDao      = new EventDAO();
            $placeEventDao = new PlaceEventDAO();
            $eventSeatDao  = new EventSeatDAO();
            $artistDao     = new ArtistDAO();

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_event = :id_event";

            $parameters["id_event"] = $event_id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {

                $event        = $eventDao->retrieveById($row["id_event"]);
                $placeEvent   = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeat    = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray = $this->retrieveArtistsByCalendarId($row["id_calendar"]);

                $calendars[] = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeat);
            }

            //Ordena los resultados por fecha ascendente
            usort($calendars, function ($a, $b) {
                return strcmp($a->getDate(), $b->getDate());
            });

            return $calendars;

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene el calendario por id.
     * @param  int $id  El id del calendario a buscar.
     * @return Calendar El objeto de tipo Calendar
     */
    public function retrieveById($id)
    {
        try {
            $calendar      = null;
            $eventDao      = new EventDAO();
            $placeEventDao = new PlaceEventDAO();
            $eventSeatDao  = new EventSeatDAO();
            $artistDao     = new ArtistDAO();

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $event        = $eventDao->retrieveById($row["id_event"]);
                $placeEvent   = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeat    = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray = $this->retrieveArtistsByCalendarId($row["id_calendar"]);

                $calendar = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeat);
            }

            return $calendar;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obitene el id del último registro.
     * @return int El id de calendario
     */
    public function retrieveLastId()
    {
        try {
            $calendar_id = null;

            $query = "SELECT id_calendar FROM " . $this->tableName . " ORDER BY id_calendar DESC LIMIT 1;";

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $calendar_id = $row["id_calendar"];
            }

            return $calendar_id;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del calendario.
     * @param  array $data El arreglo con las propiedades del calendario a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET date = :date, id_event = :id_event WHERE id_calendar = :id_calendar";

            $parameters["id_calendar"] = $data['id_calendar'];
            $parameters["date"]        = $data['date'];
            $parameters["id_event"]    = $data['id_event'];

            $this->connection->executeNonQuery($query, $parameters);

            $this->updateArtistXCalendarRows($data['id_calendar'], $data["id_artist_arr"]);

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los registros de la tabla intermedia artists_calendars con nuevos id de artistas según el id de calendario.
     * @param  int   $id_calendar     El id del calendario
     * @param  array $id_artist_arr   Los id de los artistas
     * @return void
     */
    public function updateArtistXCalendarRows($id_calendar, $id_artist_arr)
    {
        $artist_list     = $this->retrieveArtistsByCalendarId($id_calendar);
        $new_entries     = $id_artist_arr;
        $deleted_entries = [];

        foreach ($artist_list as $artist) {
            if (($key = array_search($artist->getId(), $new_entries)) !== false) {
                unset($new_entries[$key]);
            } else {
                $deleted_entries[] = $artist->getId();
            }
        }

        if (!empty($new_entries)) {
            $this->createArtistXCalendarRows($id_calendar, $new_entries);
        }

        if (!empty($deleted_entries)) {
            foreach ($deleted_entries as $id_artist) {
                $this->deleteArtistXCalendar($id_calendar, $id_artist);
            }
        }
    }
}
