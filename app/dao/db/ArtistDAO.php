<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\Artist;
use \Exception;

class ArtistDAO implements IDAO
{
    private $connection;
    private $tableName = "artists";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta un artista.
     * @param  array $data El arreglo con las propiedades del artista a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (name) VALUES (:name)";

            $parameters["name"] = $data['name'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene la lista de los artistas.
     * @return array El arreglo de artistas
     */
    public function retrieveAll()
    {
        try {
            $artistList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $artist = new Artist($row["id_artist"], $row["name"]);
                array_push($artistList, $artist);
            }

            return $artistList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene el artista por id.
     * @param  int $id El id del artista a buscar.
     * @return Artist el objeto de tipo Artist
     */
    public function retrieveById($id)
    {
        try {
            $artist = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_artist = :id_artist";

            $parameters["id_artist"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $artist = new Artist($row["id_artist"], $row["name"]);
            }

            return $artist;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Elimina un artista por id
     * @param  int $id El id del artista a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_artist = :id_artist";

            $parameters["id_artist"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del artista.
     * @param  array $data El arreglo con las propiedades del artista a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET name = :name WHERE id_artist = :id_artist";

            $parameters["id_artist"] = $data['id_artist'];
            $parameters["name"]      = $data['name'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
