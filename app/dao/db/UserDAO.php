<?php
namespace app\dao\db;


use \Exception as Exception;
use app\dao\IDAO as IDAO;
use app\models\User as User;    
use app\dao\db\Connection as Connection;

class UserDAO implements IDAO
{
    private $connection;
    private $tableName = "users";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }    

    public function create($user) {
        try {
            $query = "INSERT INTO ".$this->tableName." (id_user, email, password, first_name, last_name, is_admin) VALUES (:id_user, :email, :password, :first_name, :last_name, :is_admin);";
            $parameters["id_user"] = $user->getId();
            $parameters["email"] = $user->getEmail();
            $parameters["password"] = $user->getPassword();
            $parameters["first_name"] = $user->getFirstname();
            $parameters["last_name"] = $user->getLastname();
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            $parameters["is_admin"] = $this->stringBooleanToTinyInt($user->getAdmin());
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveAll() {
        try {
            $userList = array();
            $query = "SELECT * FROM ".$this->tableName;
            $resultSet = $this->connection->execute($query);
            foreach ($resultSet as $row) {                
                $user = new User($row["id_user"], $row["email"], $row["password"], $row["first_name"], $row["last_name"], $row["is_admin"]);
                //conversion de tinyint a string para muestreo
                $user->setAdmin($this->tinyIntBooleanToString($user->getAdmin()));
                array_push($userList, $user);
            }
            return $userList;
        }
       catch(Exception $ex) {
            throw $ex;
        }
    }

    public function retrieveById($id) {
        try {
            $user = null;
            $query = "SELECT * FROM ".$this->tableName." WHERE id_user = :id_user";
            $parameters["id_user"] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $user = new User($row["id_user"], $row["email"], $row["password"], $row["first_name"], $row["last_name"], $row["is_admin"]);
                //conversion de tinyint a string para muestreo
                $user->setAdmin($this->tinyIntBooleanToString($user->getAdmin()));
            }
            return $user;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

     public function retrieveByEmail($email) {
        try {
            $user = null;
            $query = "SELECT * FROM ".$this->tableName." WHERE email = :email";
            $parameters["email"] = $email;
            $resultSet = $this->connection->execute($query, $parameters);
            foreach ($resultSet as $row) {
                $user = new User($row["id_user"], $row["email"], $row["password"], $row["first_name"], $row["last_name"], $row["is_admin"]);
                //conversion de tinyint a string para muestreo
                $user->setAdmin($this->tinyIntBooleanToString($user->getAdmin()));
            }
            return $user;
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }



    public function delete($id) {
        try {
            $query = "DELETE FROM ".$this->tableName." WHERE id_user = :id_user";
            $parameters["id_user"] = $id;
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }            
    }

    public function update($user) {
        try {
            $query = "UPDATE ".$this->tableName." SET email = :email, password = :password, first_name = :first_name, last_name= :last_name, is_admin = :is_admin WHERE id_user = :id_user";
            $parameters["id_user"] = $user->getId();
            $parameters["email"] = $user->getEmail();
            $parameters["password"] = $user->getPassword();
            $parameters["first_name"] = $user->getFirstname();
            $parameters["last_name"] = $user->getLastname();
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            $parameters["is_admin"] = $this->stringBooleanToTinyInt($user->getAdmin());
            $this->connection->executeNonQuery($query, $parameters);   
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function stringBooleanToTinyInt($val) {
        return (($val == "true") ? 1 : 0);
    }

    public function tinyIntBooleanToString($val) {
        return (($val == 1) ? "true" : "false");
    }
}

?>