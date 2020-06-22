<?php

namespace app\controllers;

use app\dao\db\PurchaseDAO;
use app\dao\db\PurchaseLineDAO;
use app\dao\db\TicketDAO;
use app\models\Calendar;
use app\models\EventSeat;
use app\models\Purchase;
use app\models\Ticket;
use app\utils\StringUtils;

/**
 * Test class
 */
class Tests
{
    public function index()
    {
        echo "Tests/index";
    }

    public function underscores()
    {
        echo StringUtils::lowercaseAndUnderscores("Test de funcion de underscores");
    }

    public function connection($dao_type = '')
    {
        if (empty($dao_type)) {
            echo "No input given. Default to ArtistDAO<br>";
            $dao_type = "Artist";
        }

        $dao_type = StringUtils::convertToStudlyCaps($dao_type);

        echo "<p>DAO is of type $dao_type</p>";

        $class = "\app\dao\db\\$dao_type" . "DAO";
        $dao   = new $class;

        echo '<pre>';
        print_r($dao->retrieveAll());
        echo '</pre>';
    }

    public function soldout()
    {
        $es1    = new EventSeat(null, null, null, null, null, 0);
        $es2    = new EventSeat(null, null, null, null, null, 0);
        $es_arr = [$es1, $es2];
        $es_num = 1;

        foreach ($es_arr as $value) {
            echo "Remainder of Event Seat $es_num: " . $value->getRemainder() . "<br>";
            $es_num++;
        }

        $cal = new Calendar(null, null, null, null, null, $es_arr);

        echo $cal->isSoldOut() ? "Calendar is sold out" : "Calendar still has tickets available";
    }

    public function purchaseTest()
    {
        $purchase_dao = new PurchaseDAO();

        $data = ['id_client' => 8]; 
        // $purchase_dao->create($data);

        echo '<pre>';
        print_r($purchase_dao->retrieveAll());
        echo '</pre>';

        $id = 5;
        echo 'retrieving purchase number ' . $id . '<br>';

        echo '<pre>';
        print_r($purchase_dao->retrieveById($id));
        echo '</pre>';

        $id = 3;
        echo 'updating purchase number ' . $id . '<br>';

        $data = [
            'id_purchase' => $id,
            'id_client' => 12
        ];

        $purchase_dao->update($data);

        echo '<pre>';
        print_r($purchase_dao->retrieveById($id));
        echo '</pre>';
    }

    public function purchaseLineTest()
    {
        $purchase_line_dao = new PurchaseLineDAO();

        $data = [
            'id_purchase' => 1,
            'id_event_seat' => 17,
            'quantity' => 1,
            'price' => 500
        ]; 
        
        $purchase_line_dao->create($data);

        echo '<pre>';
        print_r($purchase_line_dao->retrieveAll());
        echo '</pre>';

        $id = 5;
        echo 'retrieving purchase line number ' . $id . '<br>';

        echo '<pre>';
        print_r($purchase_line_dao->retrieveById($id));
        echo '</pre>';

        $id = 3;
        echo 'updating purchase line number ' . $id . '<br>';

        $data = [
            'id_purchase_line' => $id,
            'id_purchase' => 2,
            'id_event_seat' => 18,
            'quantity' => 2,
            'price' => 1000
        ]; 

        $purchase_line_dao->update($data);

        echo '<pre>';
        print_r($purchase_line_dao->retrieveById($id));
        echo '</pre>';

        $id = 4;
        echo 'deleting purchase line number ' . $id . '<br>';

        $purchase_line_dao->delete($id);

        echo '<pre>';
        print_r($purchase_line_dao->retrieveAll());
        echo '</pre>';
    }

    public function ticketTest()
    {
        $ticket_dao = new TicketDAO();

        $data = [
            'id_purchase_line' => 8,
            'number' => 1,
            'qr' => null
        ]; 
        
        // $ticket_dao->create($data);

        echo '<pre>';
        print_r($ticket_dao->retrieveAll());
        echo '</pre>';

        $id = 6;
        echo 'retrieving ticket number ' . $id . '<br>';

        echo '<pre>';
        print_r($ticket_dao->retrieveById($id));
        echo '</pre>';

        $id = 12;
        echo 'updating ticket number ' . $id . '<br>';

        $data = [
            'id_ticket' => $id,
            'id_purchase_line' => 12,
            'number' => 6,
            'qr' => null
        ];

        $ticket_dao->update($data);

        echo '<pre>';
        print_r($ticket_dao->retrieveById($id));
        echo '</pre>';

        $id = 6;
        echo 'deleting purchase line number ' . $id . '<br>';

        $ticket_dao->delete($id);

        echo '<pre>';
        print_r($ticket_dao->retrieveAll());
        echo '</pre>';
    }
}
