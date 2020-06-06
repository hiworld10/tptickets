<?php 

namespace app\controllers;

use core\Controller;
use app\controllers\Users;

class Events extends Controller {

    function __construct() {
        $this->calendar_dao = $this->dao('Calendar');
        $this->event_dao = $this->dao('Event');
    }

    public function show($id_event) {
        
        $data['calendars'] = $this->calendar_dao->retrieveByEventId($id_event);
        if(isset($data['calendars'])) {
            $this->view('home/show_event', $data);
        } else {
            $this->index();
        }
    }
}
