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

    /**
     * Crea y da de alta un usuario.
     * @param  array $data El arreglo con las propiedades del usuario a crear
     * @return void
     */
    public function create($data) {
        try {
            $query = "INSERT INTO ".$this->tableName." (email, password, name, surname, is_admin) VALUES (:email, :password, :name, :surname, :is_admin);";
            
            $parameters["email"] = $data['email'];
            $parameters["password"] = Password::hash($data['password']);
            $parameters["name"] = $data['name'];
            $parameters["surname"] = $data['surname'];
            
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            if (isset($data['is_admin'])) {
                $parameters["is_admin"] = $this->stringBooleanToTinyInt($data['is_admin']);
            } else {
                $parameters['is_admin'] = 0;
            }
            
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la lista de los usuarios.
     * @return array El arreglo de usuarios
     */
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
    
    /**
     * Obtiene el usuario por id.
     * @param  int $id El id del usuario a buscar.
     * @return User el objeto de tipo User
     */
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

    /**
     * Obtiene el usuario por email.
     * @param  string $email El email del usuario a buscar.
     * @return User el objeto de tipo User
     */
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
    
    /**
     * Elimina un usuario por id
     * @param  int $id El id del usuario a eliminar
     * @return void
     */
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

    /**
     * Actualiza los datos del usuario.
     * @param  array $data El arreglo con las propiedades del usuario a actualizar 
     * @return void
     */
    public function update($data) {
        try {
            $query = "UPDATE ".$this->tableName." SET email = :email, password = :password, name = :name, surname= :surname, is_admin = :is_admin WHERE id_user = :id_user";
            
            $parameters["id_user"] = $data['id_user'];
            $parameters["email"] = $data['email'];
            $parameters["password"] = Password::hash($data['password']);
            $parameters["name"] = $data['name'];
            $parameters["surname"] = $data['surname'];
            
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            if (isset($data['is_admin'])) {
                $parameters["is_admin"] = $this->stringBooleanToTinyInt($data['is_admin']);
            } else {
                $parameters['is_admin'] = 0;
            }
            
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos del usuario sin cambiar la contraseña.
     * @param  array $data El arreglo con las propiedades del usuario a actualizar 
     * @return void
     */
    public function updateWithoutPassword($data) {
        try {
            $query = "UPDATE ".$this->tableName." SET email = :email, name = :name, surname= :surname, is_admin = :is_admin WHERE id_user = :id_user";
            
            $parameters["id_user"] = $data['id_user'];
            $parameters["email"] = $data['email'];
            $parameters["name"] = $data['name'];
            $parameters["surname"] = $data['surname'];
            
            //conversion de valores para la tabla (admite solo 0 y 1 (tinyint))
            if (isset($data['is_admin'])) {
                $parameters["is_admin"] = $this->stringBooleanToTinyInt($data['is_admin']);
            } else {
                $parameters['is_admin'] = 0;
            }
            
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex) {
            throw $ex;
        }        
    }

    /**
     * Verifica si las credenciales introducidas son validas y retorna el correspondiente usuario en caso de que lo haga exitosamente.
     * @param  string $email    El email
     * @param  password $password La contraseña
     * @return mixed           El objeto User o false
     */
    public function authenticate($email, $password)
    {
        $user = $this->retrieveByEmail($email);

        if ($user) {
            return (Password::verify($password, $user->getPassword())) ? $user : false;
        }

        return false;
    }    

    private function stringBooleanToTinyInt($val) {
        return (($val == "true") ? 1 : 0);
    }

    private function tinyIntBooleanToString($val) {
        return (($val == 1) ? "true" : "false");
    }
}

?>