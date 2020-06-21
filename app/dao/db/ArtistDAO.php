<?php
namespace app\dao\db;

use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\Artist as Artist;    
use app\dao\db\Connection as Connection;

class ArtistDAO implements IDAO
{
    private $connection;
    private $tableName = "artists";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    public function create($data) {
        try {
            $query = "INSERT INTO ".$this->tableName." (name) VALUES (:name);";

            $parameters["name"] = $data['name'];
            
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $artistList = array();
            $query = "SELECT * FROM ".$this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {                
                $artist = new Artist($row["id_artist"], $row["name"]);
                array_push($artistList, $artist);
            }
            return $artistList;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $artist = null;
            $query = "SELECT * FROM ".$this->tableName." WHERE id_artist = :id_artist";
            $parameters["id_artist"] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $artist = new Artist($row["id_artist"], $row["name"]);
            }
            return $artist;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_artist = :id_artist";
            $parameters["id_artist"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($data) {
        try {
            $query = "UPDATE ".$this->tableName." SET name = :name WHERE id_artist = :id_artist";
            $parameters["id_artist"] = $data['id_artist'];
            $parameters["name"] = $data['name'];
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
}
?>