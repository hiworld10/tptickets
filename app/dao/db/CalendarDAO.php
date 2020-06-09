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

    public function create($calendar)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (date, id_event) VALUES (:date, :id_event);";
            $parameters["date"]     = $calendar["date"];
            $parameters["id_event"] = $calendar["id_event"];
            $this->connection->executeNonQuery($query, $parameters);

            if (isset($calendar['id_artist_arr'])) {
                $calendar_id = $this->retrieveLastId();
                $this->createArtistXCalendarRows($calendar_id, $calendar['id_artist_arr']);
            }

        } catch (Exception $ex) {
            throw $ex;
        }
    }

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

    public function deleteArtistXCalendarByCalendarId($calendarId)
    {
        try {
            $query = "DELETE FROM artists_calendars WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll()
    {
        try {
            $calendarList  = array();
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
                $calendar       = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeatArray[0]);
                array_push($calendarList, $calendar);
            }
            return $calendarList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveArtistXCalendarByArtistId($calendarId)
    {
        try {
            $artistXcalendar           = null;
            $artistDao                 = new ArtistDAO();
            $query = "SELECT id_artist FROM artists_calendars WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $artist = $artistDao->retrieveById($row['id_artist']);
                array_push($artists_calendar_array, $artist);
            }
            return $artists_calendar_array;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveArtistsByCalendarId($calendarId)
    {
        try {
            $artists_calendar_array    = array();
            $artistDao                 = new ArtistDAO();
            $query = "SELECT * FROM artists_calendars WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendarId;
            $resultSet                 = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $artist = $artistDao->retrieveById($row['id_artist']);
                array_push($artists_calendar_array, $artist);
            }

            return $artists_calendar_array;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveByEventId($eventId)
    {
        try {
            $calendars              = [];
            $eventDao               = new EventDAO();
            $placeEventDao          = new PlaceEventDAO();
            $eventSeatDao           = new EventSeatDAO();
            $artistDao              = new ArtistDAO();
            $query = "SELECT * FROM " . $this->tableName . " WHERE id_event = :id_event";
            $parameters["id_event"] = $eventId;
            $resultSet              = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $event        = $eventDao->retrieveById($row["id_event"]);
                $placeEvent   = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeat    = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray = $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendars[]  = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeat);
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

    public function retrieveById($id)
    {
        try {
            $calendar                  = null;
            $eventDao                  = new EventDAO();
            $placeEventDao             = new PlaceEventDAO();
            $eventSeatDao              = new EventSeatDAO();
            $artistDao                 = new ArtistDAO();
            $query = "SELECT * FROM " . $this->tableName . " WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $id;
            $resultSet                 = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $event        = $eventDao->retrieveById($row["id_event"]);
                $placeEvent   = $placeEventDao->retrieveByCalendarId($row["id_calendar"]);
                $eventSeat    = $eventSeatDao->retrieveByCalendarId($row["id_calendar"]);
                $artistsArray = $this->retrieveArtistsByCalendarId($row["id_calendar"]);
                $calendar     = new Calendar($row["id_calendar"], $row["date"], $event, $artistsArray, $placeEvent, $eventSeat);
            }
            return $calendar;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveCalendarsByString($string)
    {
        try {
            $calendarList = array();
            $eventDao     = new EventDAO();
            $eventList    = $eventDao->retrieveByString($string);
            $query = "SELECT * FROM " . $this->tableName . " WHERE id_event = :id_event";
            foreach ($eventList as $value) {
                $parameters["id_event"] = $value->getId();
                $resultSet              = $this->connection->execute($query, $parameters);
                foreach ($resultSet as $row) {
                    array_push($calendarList, $this->retrieveByEventId($parameters["id_event"]));
                }
            }
            return $calendarList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveLastId()
    {
        try {
            $calendarId = null;
            $query = "SELECT id_calendar FROM " . $this->tableName . " ORDER BY id_calendar DESC LIMIT 1;";
            $resultSet  = $this->connection->execute($query);
            foreach ($resultSet as $row) {
                $calendarId = $row["id_calendar"];
            }
            return $calendarId;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update($calendar)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET date = :date, id_event = :id_event WHERE id_calendar = :id_calendar";
            $parameters["id_calendar"] = $calendar['id_calendar'];
            $parameters["date"]        = $calendar['date'];
            $parameters["id_event"]    = $calendar['id_event'];
            $this->connection->executeNonQuery($query, $parameters);
            $this->updateArtistXCalendarRows($calendar['id_calendar'], $calendar["id_artist_arr"]);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

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
