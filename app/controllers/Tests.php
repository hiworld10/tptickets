<?php

namespace app\controllers;

use app\dao\db\EventSeatDAO;
use app\models\Calendar;
use app\models\EventSeat;
use app\utils\StringUtils;

/**
 * Test class
 */
class Tests extends \core\Controller
{
    public function index()
    {
        echo "Tests/index";
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

    public function mailOrderDetails()
    {
        // echo '<pre>';
        // print_r($_SESSION['purchase_data']);
        // echo '</pre>';
        
        // View::render('mail/purchase_details_html', $_SESSION['purchase_data']);

        $mail = new \app\Mail();
        $mail->purchaseDetails('receiver@blabla.com', $_SESSION['purchase_data']);
    }

    public function welcomeMessage()
    {
        $mail = new \app\Mail();
        $mail->sendWelcomeMessage('receiver@blabla.com', ['name' => 'Nuevo Usuario']);
        echo "Mensaje enviado";
    }
}
