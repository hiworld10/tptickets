<?php
namespace app\dao\db;

use \Exception;
use app\dao\IDAO;
use app\models\User;    
use app\dao\db\Connection;
use app\utils\Password;

class UserDAO implements IDAO
{
    private $connection;
    private $tableName = "users";

    public function __construct() {
        $this->connection = Connection::getInstance();
    }    

    public function create($user) {
        try {
            $query = "INSERT INTO ".$this->tableName." (email, password, name, surname, is_admin) VALUES (:email, :password, :name, :surname, :is_admin);";
            
            $parameters["email"] = $user['email'];
            $parameters["password"] = Password::hash($user['password']);
            $parameters["name"] = $user['name'];
            $parameters["surname"] = $user['surname'];
            
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            if (isset($user['is_admin'])) {
                $parameters["is_admin"] = $this->stringBooleanToTinyInt($user['is_admin']);
            } else {
                $parameters['is_admin'] = 0;
            }
            
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
                $user = new User($row["id_user"], $row["email"], $row["password"], $row["name"], $row["surname"], $row["is_admin"]);
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
                $user = new User($row["id_user"], $row["email"], $row["password"], $row["name"], $row["surname"], $row["is_admin"]);
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
                $user = new User($row["id_user"], $row["email"], $row["password"], $row["name"], $row["surname"], $row["is_admin"]);
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
            $query = "UPDATE ".$this->tableName." SET email = :email, password = :password, name = :name, surname= :surname, is_admin = :is_admin WHERE id_user = :id_user";
            
            $parameters["id_user"] = $user['id_user'];
            $parameters["email"] = $user['email'];
            $parameters["password"] = Password::hash($user['password']);
            $parameters["name"] = $user['name'];
            $parameters["surname"] = $user['surname'];
            
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            if (isset($user['is_admin'])) {
                $parameters["is_admin"] = $this->stringBooleanToTinyInt($user['is_admin']);
            } else {
                $parameters['is_admin'] = 0;
            }
            
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    public function updateWithoutPassword($user) {
        try {
            $query = "UPDATE ".$this->tableName." SET email = :email, name = :name, surname= :surname, is_admin = :is_admin WHERE id_user = :id_user";
            
            $parameters["id_user"] = $user['id_user'];
            $parameters["email"] = $user['email'];
            $parameters["name"] = $user['name'];
            $parameters["surname"] = $user['surname'];
            
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            if (isset($user['is_admin'])) {
                $parameters["is_admin"] = $this->stringBooleanToTinyInt($user['is_admin']);
            } else {
                $parameters['is_admin'] = 0;
            }
            
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