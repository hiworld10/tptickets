<?php
    namespace dao\db;

    use \Exception as Exception;
    use dao\IDAO as IDAO;
    use model\Artist as Artist;    
    use dao\db\Connection as Connection;

    class ArtistDAO implements IDAO
    {
        private $connection;
        private $tableName = "artists";

        public function create($artist) {
            try {
                $query = "INSERT INTO ".$this->tableName." (id_artist, name) VALUES (:id_artist, :name);";
                
                $parameters["id_artist"] = $artist->getId();
                $parameters["name"] = $artist->getName();

                $this->connection = Connection::getInstance();

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

                $this->connection = Connection::getInstance();

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
                
                $this->connection = Connection::getInstance();

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
                $this->connection = Connection::getInstance();
                $this->connection->executeNonQuery($query, $parameters);   
            }
            catch(Exception $ex) {
                throw $ex;
            }            
        }

        public function update($artist) {
         try {
            $query = "UPDATE ".$this->tableName." SET name = :name WHERE id_artist = :id_artist";
            $parameters["id_artist"] = $artist->getId();
            $parameters["name"] = $artist->getName();
     
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }

    }
    }
?>