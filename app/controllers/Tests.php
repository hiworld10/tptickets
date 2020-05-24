<?php 

namespace app\controllers;

/**
 * Test class
 */
class Tests {

    public function index() {
        echo "Tests/index";
    }

    public function connection($dao_type) {
        echo "<p>DAO is of type $dao_type</p>";
        $dao_type = ucfirst($dao_type);
        $class = "\app\dao\db\\$dao_type" . "DAO";
        $dao = new $class;
        echo '<pre>';
         print_r($dao->retrieveAll());
         echo '</pre>'; 
    }
}

 ?>