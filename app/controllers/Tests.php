<?php

namespace app\controllers;

use app\dao\db\EventSeatDAO;
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

    public function hasSeats()
    {
        $es_dao = new EventSeatDAO();

        $es1 = new EventSeat(null, null, null, null, null, 2);

        echo '<pre>';
        var_dump($es1->hasAvailable(3));
        echo '</pre>';

        $es2 = $es_dao->retrieveById(11);

        echo '<pre>';
        var_dump($es2->hasAvailable(2));
        echo '</pre>';


        $es3 = $es_dao->retrieveById(12);
        

        echo '<pre>';
        var_dump($es3->isSoldOut(12));
        echo '</pre>';
    }
}
