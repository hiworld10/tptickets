<?php

namespace app\dao\db;

use app\dao\IDAO;
use app\dao\db\Connection;
use app\dao\db\EventDAO;
use app\dao\db\PurchaseLineDAO;
use app\models\Purchase;

class PurchaseDAO implements IDAO
{
    private $tableName = "purchases";
    private $connection;

    public function __construct()
    {   

        $this->connection = Connection::getInstance();
    }

    // Acciones de carro de compra
    
    /**
     * Inicializa el carro de compra
     * @return void
     */
    public static function initCart()
    {
        // Inicialización de carro de compra
        if (!isset($_SESSION['tptickets_items']) || !isset($_SESSION['tptickets_subtotal'])) {
            $_SESSION['tptickets_items']    = [];
            $_SESSION['tptickets_subtotal'] = 0;
        }        
    }

    /**
     * Agrega un nuevo elemento al carro de compra
     * @param array $data El arreglo con los datos relevantes del evento para su compra
     * @return boolean Verdadero o falso dependiendo de si el carro de compra está vacío o no
     */
    public function addNewLineInSession($data)
    {
        $event_dao = new EventDAO();
        $event = $event_dao->retrieveById($data['id_event']);
        $subtotal = $data['price'] * $data['amount'];

        $_SESSION['tptickets_items'][] = [
            'id_event_seat' => $data['id_event_seat'],
            'seat_type'     => $data['seat_type'],
            'amount'        => $data['amount'],
            'price'         => $data['price'],
            'event'         => $event,
            'date'          => $data['date'],
            'subtotal'      => $subtotal,
        ];  

        $_SESSION['tptickets_subtotal'] += $subtotal;

        return !empty($_SESSION['tptickets_items']) ? true : false;
    }

    /**
     * Obtiene los paquetes de descuento vigentes con su respectivo porcentaje de descuento
     * @return array El arreglo con los paquetes y sus descuentos
     */
    public function getBundlesWithDiscounts()
    {   
        $bundle_ids = [];

        foreach ($_SESSION['tptickets_items'] as $value) {
            if ($value['event']->getBundle()) {
                $bundle_ids[] = $value['event']->getBundle()->getId();        
            }    
        }

        $counted_values = array_count_values($bundle_ids);
        $applicable_bundle_ids = [];

        foreach ($counted_values as $key => $value) {
            if ($value >= 2) {
                $applicable_bundle_ids[] = $key;        
            }
        }

        $bundles_with_discount = [];

        foreach ($applicable_bundle_ids as $bundle_id) {
            $subtotal_pre_discount = 0;
            $bundle = null;

            foreach ($_SESSION['tptickets_items'] as $item) {
                if ($item['event']->getBundle()) {
                    if ($item['event']->getBundle()->getId() == $bundle_id) {
                        $subtotal_pre_discount += $item['subtotal'];
                        if (!$bundle) {
                            $bundle = $item['event']->getBundle();
                        }
                    }
                }
            }

            $discount_value = $subtotal_pre_discount * $bundle->getDiscount() / 100;

            $bundles_with_discount[] = [
                'bundle' => $bundle,
                'discount_value' => $discount_value
            ];
        }

        return $bundles_with_discount;
    }

    /**
     * Quita un elemento del carro de compra
     * @param  int $id_event_seat el id del asiento de evento a quitar del carro
     * @return boolean verdadero o falso dependiendo de si el elemento fue borrado o no
     */
    public function removeLineInSession($id_event_seat)
    {
        $deleted = false;

        foreach ($_SESSION['tptickets_items'] as $key => $value) {

            if ($id_event_seat == $value['id_event_seat']) {
                $_SESSION['tptickets_subtotal'] -= $value['subtotal'];

                unset($_SESSION['tptickets_items'][$key]);

                $deleted = true;

                break;
            }
        }

        return $deleted;
    }

    /**
     * Quita todos los elementos del carro de compra
     * @return boolean verdadero o falso dependiendo de si el elemento fue borrado o no
     */
    public function removeAllLinesInSession()
    {
        $deleted = false;

        $_SESSION['tptickets_items'] = [];

        if (empty($_SESSION['tptickets_items'])) {
            $_SESSION['tptickets_subtotal'] = 0;

            $deleted = true;
        }

        return $deleted;
    }

    /**
     * Prepara los datos a momstrar en la pantalla de confirmación de compra
     * @return array El arreglo con los detalles a mostrar
     */
    public function prepareCheckoutDetails()
    {   
        $subtotal = $_SESSION['tptickets_subtotal'];
        $bundles = $this->getBundlesWithDiscounts();

        if (empty($bundles)) {
            $total = $subtotal;
        } else {
            $discount_total = 0;
            foreach ($bundles as $bundle) {
                $discount_total += $bundle['discount_value']; 
            }
            $total = $subtotal - $discount_total;
        }

        $_SESSION['tptickets_total'] = $total;

        return [
            'items'    => $_SESSION['tptickets_items'],
            'subtotal' => $subtotal,
            'total'    => $total,
            'bundles'  => $this->getBundlesWithDiscounts()
        ];
    }

    // Acceso a BD
    
    /**
     * Crea y da de alta una compra.
     * @param  array $data El arreglo con las propiedades de la compra a crear
     * @return void
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id_user, total) VALUES (:id_user, :total)";

            $parameters["id_user"] = $data['id_user'];
            $parameters["total"] = $data['total'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la lista de las compras.
     * @return array El arreglo de compras
     */
    public function retrieveAll()
    {
        try {
            $purchases = [];
            $purchase_line_arr = [];
            $purchase_line_dao = new PurchaseLineDAO();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $purchase_line_arr = $purchase_line_dao->retrieveByPurchaseId($row['id_purchase']);
                $purchase = new Purchase($row['id_purchase'], $row['id_user'], $row['total'], $row['date'], $purchase_line_arr);
                array_push($purchases, $purchase);
            }

            return $purchases;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Obtiene la compra por id.
     * @param  int $id El id de la compra a buscar.
     * @return Purchase el objeto de tipo Purchase
     */
    public function retrieveById($id)
    {
        try {
            $purchase = null;
            $purchase_line_arr = [];
            $purchase_line_dao = new PurchaseLineDAO();            

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_purchase = :id_purchase";

            $parameters["id_purchase"] = $id;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $purchase_line_arr = $purchase_line_dao->retrieveByPurchaseId($row['id_purchase']);
                $purchase = new Purchase($row['id_purchase'], $row['id_user'], $row['total'], $row['date'], $purchase_line_arr);
            }

            return $purchase;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene el monto total de todas las compras efectuadas.
     * @return double El monto total
     */
    public function retrieveTotal()
    {
        try {
            $total = 0;

            $query = "SELECT total FROM " . $this->tableName;

            $resultSet = $this->connection->execute($query);
            
            foreach ($resultSet as $row) {
                $total += (double)$row['total']; 
            }

            return $total;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene el id de la ultima compra registrada en el sistema
     * @return int el id de la ultima compra
     */
    public function retrieveLastId()
    {
        try {
            $id_purchase = null;          

            $query = "SELECT id_purchase FROM " . $this->tableName . " ORDER BY id_purchase DESC LIMIT 1";

            $resultSet = $this->connection->execute($query);

            foreach ($resultSet as $row) {
                $id_purchase = $row['id_purchase'];
            }

            return $id_purchase;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene todas las compras hechas por un usuario específico
     * @param  int $id_user El id del usuario
     * @return array El arreglo de compras
     */
    public function retrieveByUserId($id_user)
    {
        try {
            $purchase_arr = [];
            $purchase_line_arr = [];
            $purchase_line_dao = new PurchaseLineDAO();            

            $query = "SELECT * FROM " . $this->tableName . " WHERE id_user = :id_user";

            $parameters["id_user"] = $id_user;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $purchase_line_arr = $purchase_line_dao->retrieveByPurchaseId($row['id_purchase']);
                $purchase_arr[] = new Purchase($row['id_purchase'], $row['id_user'], $row['total'], $row['date'], $purchase_line_arr);

            }

            return $purchase_arr;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Obtiene todas las compras efectuadas en una fecha específica
     * @param  string $date La fecha
     * @return array El arreglo de compras
     */
    public function retrieveByDate($date)
    {
        try {
            $purchase_arr = [];
            $purchase_line_arr = [];
            $purchase_line_dao = new PurchaseLineDAO();            

            $query = "SELECT * FROM " . $this->tableName . " WHERE DATE(date) = :date";

            $parameters["date"] = $date;

            $resultSet = $this->connection->execute($query, $parameters);

            foreach ($resultSet as $row) {
                $purchase_line_arr = $purchase_line_dao->retrieveByPurchaseId($row['id_purchase']);
                $purchase_arr[] = new Purchase($row['id_purchase'], $row['id_user'], $row['total'], $row['date'], $purchase_line_arr);

            }

            return $purchase_arr;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Elimina una compra por id
     * @param  int $id El id de la compra a eliminar
     * @return void
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id_purchase = :id_purchase";

            $parameters["id_purchase"] = $id;

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza los datos de la compra.
     * @param  array $data El arreglo con las propiedades de la compra a actualizar 
     * @return void
     */
    public function update($data)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET id_user = :id_user, total = :total WHERE id_purchase = :id_purchase";

            $parameters['id_user']   = $data['id_user'];
            $parameters['id_purchase'] = $data['id_purchase'];
            $parameters['total']       = $data['total'];

            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
