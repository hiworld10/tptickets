<?php 

namespace app\controllers;

use app\utils\StringUtils;

/**
 * Test class
 */
class Tests {

    public function index() {
        echo "Tests/index";
    }

    public function connection($dao_type) {
        $dao_type = StringUtils::convertToStudlyCaps($dao_type);
        echo "<p>DAO is of type $dao_type</p>";
        $class = "\app\dao\db\\$dao_type" . "DAO";
        $dao = new $class;
        echo '<pre>';
         print_r($dao->retrieveAll());
         echo '</pre>'; 
    }
}

 ?>