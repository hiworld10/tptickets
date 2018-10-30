<?php
    namespace dao\db;

    use \Exception as Exception;
    use dao\IDAO as IDAO;
    use model\User as User;    
    use dao\db\Connection as Connection;

/**Problema a resolver: la tabla 'artists_calendars' no esta asociada directamente con
ninguna clase del modelo, por ende no se puede retornar instancias de clases, sino arreglos con valores puros. Determinar de que manera acceder a ellos para su uso debido.
*   
*/

    class ArtistCalendarDAO implements IDAO
    {
        private $connection;
        private $tableName = "artists_calendars";

        public function create($artistCalendarValArray) {
            try {
                $query = "INSERT INTO ".$this->tableName." (id_artist_calendar, id_calendar, id_artist);";
                
                $parameters["id_artist_calendar"] = $artistCalendarValArray[0];
                $parameters["id_calendar"] = $artistCalendarValArray[1];
                $parameters["id_artist"] = $artistCalendarValArray[2];
             
                $this->connection = Connection::getInstance();

                $this->connection->executeNonQuery($query, $parameters);
            }
            catch(Exception $ex) {
                throw $ex;
            }
        }

        public function retrieveAll() {
            try {
                $artistCalendarList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);
                
                foreach ($resultSet as $row) { 
                    array_push($artistCalendarList, $row);
                }

                return $artistCalendarList;
           }
            catch(Exception $ex) {
                throw $ex;
        }
    }

        public function retrieveById($id) {
            try {
                $artistCalendarRow = null;

                $query = "SELECT * FROM ".$this->tableName." WHERE id_artist_calendar = :id_artist_calendar";
                
                $parameters["id_artist_calendar"] = $id;
                
                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query, $parameters);
                
                $artistCalendarRow = $resultSet;
                            
                return $artistCalendarRow;
            }
            catch(Exception $ex) {
                throw $ex;
            }
        }

        public function delete($id) {
            try {
                $query = "DELETE FROM ".$this->tableName." WHERE id_artist_calendar = :id_artist_calendar";
                $parameters["id_artist_calendar"] = $id;
                $this->connection = Connection::getInstance();
                $this->connection->executeNonQuery($query, $parameters);   
            }
            catch(Exception $ex) {
                throw $ex;
            }            
        }

        public function update($artistCalendarValArray) {
            try {
                $query = "UPDATE ".$this->tableName." SET id_artist_calendar = :id_artist_calendar, id_calendar = :id_calendar, id_artist = :id_artist WHERE id_artist_calendar = :id_artist_calendar";

                $parameters["id_artist_calendar"] = $artistCalendarValArray[0];
                $parameters["id_calendar"] = $artistCalendarValArray[1];
                $parameters["id_artist"] = $artistCalendarValArray[2];

                $this->connection = Connection::getInstance();
                $this->connection->executeNonQuery($query, $parameters);   
            }
            catch(Exception $ex) {
                throw $ex;
            }
        }

        protected function mapear($value) {

            $value = is_array($value) ? $value : [];

            /*$resp = array_map(function($p){   // array_map( p1, p2)
                return array('id_artist_calendar'=>$p['id_artist_calendar'], 'id_calendar'=>$p['id_calendar'], 'id_artist'=>$p['id_artist']);
            }, $value);   // $value es cada array q quiero convertir a objeto*/

               return $value; //o resp si llamo a array_map()

        }
    }
?>