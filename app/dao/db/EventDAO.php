<?php

namespace app\dao\db;

use \Exception;
use app\dao\IDAO;
use app\dao\db\BundleDAO;
use app\dao\db\CategoryDAO;
use app\dao\db\Connection;
use app\models\Event;
use app\models\Image;

class EventDAO implements IDAO
{
    private $connection;
    private $tableName = "events";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un evento.
     * @param  array $data El arreglo con las propiedades del evento a crear
     * @return void
     */
    public function create($data)
    {
        try {
            // bundle_id se añade por separado
            $query = "INSERT INTO " . $this->tableName . " (name, id_category, image) VALUES (:name, :id_category, :image)";

            $parameters["name"]        = $data['name'];
            $parameters["id_category"] = $data['id_category'];
            $parameters["image"]       = $data['image'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene la lista de los eventos.
     * @return array El arreglo de eventos
     */
    public function retrieveAll()
    {
        try {
            $eventList   = [];
            $category_dao = new CategoryDAO();
            $bundle_dao = new BundleDAO();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $category = $category_dao->retrieveById($row["id_category"]);
                $bundle = $bundle_dao->retrieveById($row["id_bundle"]);
                $image    = new Image();
                $image->setPath($row['image']);
                $event = new Event($row["id_event"], $row["name"], $category, $image);
                if ($bundle) {
                    $event->setBundle($bundle);
                }
                array_push($eventList, $event);
            }

            return $eventList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene los eventos que disponen de un Calendario activo
     * @return array El arreglo de eventos
     */
    public function retrieveAllActive()
    {

        try {
            $eventList      = [];
            $id_event_array = [];

            $query = "SELECT id_event FROM calendars";

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $id_event_array[] = $row['id_event'];
            }

            $id_event_array = array_unique($id_event_array);

            foreach ($id_event_array as $id) {
                $eventList[] = $this->retrieveById($id);
            }

            return $eventList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene los eventos que disponen de un Calendario activo por string, producto de una búsqueda
     * @param  string $string El string buscado
     * @return array         El arreglo de eventos
     */
    public function retrieveActiveEventsByString($string)
    {
        try {
            $events = $this->retrieveAllActive();

            $results = [];
            $category_dao = new CategoryDAO();
            $bundle_dao = new BundleDAO();

            $query = "SELECT * FROM events WHERE id_event = :id_event AND name LIKE '%" . $string . "%' ";


            foreach ($events as $event) {
                $parameters["id_event"] = $event->getId();

                $row = $this->connection->execute($query, $parameters);

                $resultSet = $this->connection->execute($query, $parameters);

                foreach ($resultSet as $row) {
                    $category = $category_dao->retrieveById($row["id_category"]);
                    $bundle = $bundle_dao->retrieveById($row["id_bundle"]);
                    $image    = new Image();
                    $image->setPath($row['image']);
                    $event = new Event($row["id_event"], $row["name"], $category, $image);
                    if ($bundle) {
                        $event->setBundle($bundle);
                    }
                    $results[] = $event;
                }
            }

            return $results;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene los eventos que sean de una Categoría de evento específica
     * @param  int $id_category El id de Categoría
     * @return array              El arreglo de eventos
     */
    public function retrieveActiveEventsByCategoryId($id_category)
    {
        try {
            $events = $this->retrieveAllActive();

            $results = [];
            $category_dao = new CategoryDAO();
            $bundle_dao = new BundleDAO();

            $query = "SELECT * FROM events WHERE id_event = :id_event AND id_category = :id_category";

            foreach ($events as $event) {
                $parameters["id_event"] = $event->getId();
                $parameters["id_category"] = $id_category;

                $resultSet = $this->connection->execute($query, $parameters);

                foreach ($resultSet as $row) {
                    $category = $category_dao->retrieveById($row["id_category"]);
                    $bundle = $bundle_dao->retrieveById($row["id_bundle"]);
                    $image    = new Image();
                    $image->setPath($row['image']);
                    $event = new Event($row["id_category"], $row["name"], $category, $image);
                    if ($bundle) {
                        $event->setBundle($bundle);
                    }
                    $results[] = $event;
                }
            }

            return $results;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene eventos por fecha de realización de los mismos
     * @param  string $date La fecha (yyyy-mm-dd) a buscar
     * @return array       El arreglo de eventos
     */
    public function retrieveEventsByDate($date)
    {
        $event_ids = [];
        $events = [];

        $query = "SELECT id_event FROM calendars WHERE date = :date";

        $parameters['date'] = $date;

        $resultSet = $this->connection->execute($query, $parameters);
        
        foreach ($resultSet as $row) {
            $event_ids[] = $row['id_event'];
        }

        $event_ids = array_unique($event_ids);

        foreach ($event_ids as $id) {
            $events[] = $this->retrieveById($id);
        }

        return $events;
    }

    /**
     * Obtiene eventos que contengan un artista específico
     * @param  int $id_artist El id de artista
     * @return array            El arreglo de eventos
     */
    public function retrieveEventsByArtistId($id_artist)
    {
        $query = "SELECT id_calendar FROM artists_calendars WHERE id_artist = :id_artist";

        $parameters['id_artist'] = $id_artist;

        $resultSet = $this->connection->execute($query, $parameters);

        foreach ($resultSet as $row) {
            $calendar_ids[] = $row['id_calendar'];
        }

        unset($parameters['id_artist']);

        $query = "SELECT id_event FROM calendars WHERE id_calendar = :id_calendar";

        foreach ($calendar_ids as $id) {
            $parameters['id_calendar'] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $event_ids[] = $row['id_event'];
            }
        }

        $event_ids = array_unique($event_ids);

        foreach ($event_ids as $id) {
            $events[] = $this->retrieveById($id);
        }

        return $events;
    }

    /**
     * Obtiene el evento por id.
     * @param  int $id El id del evento a buscar.
     * @return Event el objeto de tipo Event
     */
    public function retrieveById($id)
    {
        try {
            $event       = null;
            $category_dao = new CategoryDAO();
            $bundle_dao = new BundleDAO();

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_event = :id_event";

            $parameters["id_event"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $category = $category_dao->retrieveById($row["id_category"]);
                $bundle = $bundle_dao->retrieveById($row["id_bundle"]);
                $image    = new Image();
                $image->setPath($row['image']);
                $event = new Event($row["id_event"], $row["name"], $category, $image);
                if ($bundle) {
                    $event->setBundle($bundle);
                }
            }

            return $event;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Elimina un evento por id
     * @param  int $id El id del evento a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_event = :id_event";

            $parameters["id_event"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del evento.
     * @param  array $data El arreglo con las propiedades del evento a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET name = :name, id_category = :id_category, image = :image WHERE id_event = :id_event";

            $parameters["id_event"]    = $data['id_event'];
            $parameters["name"]        = $data['name'];
            $parameters["id_category"] = $data['id_category'];
            $parameters["image"]       = $data['image'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }

    }

    /**
     * Agrega un id de paquete a un evento
     * @param int $id_event  El id del evento a agregar un paquete
     * @param int $id_bundle El id del paquete
     */
    public function setBundle($id_event, $id_bundle)
    {
        try {
            // Debido a que es opcional, la propiedad de paquete se añade aparte
            $query = "UPDATE " . $this->tableName . " SET id_bundle = :id_bundle WHERE id_event = :id_event";

            $parameters["id_event"]  = $id_event;
            $parameters["id_bundle"] = $id_bundle;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Quita el id asociado a un paquete de un evento
     * @param  int $id_event El id del evento a quitar un paquete
     * @return void
     */
    public function unsetBundle($id_event)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET id_bundle = NULL WHERE id_event = :id_event";

            $parameters["id_event"]  = $id_event;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
