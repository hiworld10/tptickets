<?php

namespace app\dao\db;

use app\dao\db\Connection;
use app\dao\IDAO;
use app\models\Category;
use \Exception;

class CategoryDAO implements IDAO
{
    private $connection;
    private $tableName = "categories";

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Crea y da de alta una categoría.
     * @param  array $data El arreglo con las propiedades de la categoría a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (type) VALUES (:type)";

            $parameters["type"] = $data['type'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene la lista de las categorías.
     * @return array El arreglo de categorías
     */
    public function retrieveAll()
    {
        try {
            $categoryList = [];

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $category = new Category($row["id_category"], $row["type"]);
                array_push($categoryList, $category);
            }

            return $categoryList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene la categoría por id.
     * @param  int $id El id de la categoría a buscar.
     * @return Category el objeto de tipo Category
     */
    public function retrieveById($id)
    {
        try {
            $category = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_category = :id_category";

            $parameters["id_category"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $category = new Category($row["id_category"], $row["type"]);
            }

            return $category;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Elimina una categoría por id
     * @param  int $id El id de la categoría a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_category = :id_category";

            $parameters["id_category"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Actualiza los datos de la categoría.
     * @param  array $data El arreglo con las propiedades de la categoría a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET type = :type WHERE id_category = :id_category";

            $parameters["id_category"] = $data['id_category'];
            $parameters["type"]        = $data['type'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
