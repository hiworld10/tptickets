<?php 

namespace app\controllers;

class Events extends \core\Controller {

    function __construct() {
        $this->calendar_dao = $this->dao('Calendar');
    }

    public function show($id_event) {
        
        $data['calendars'] = $this->calendar_dao->retrieveByEventId($id_event);
        if(!empty($data['calendars'])) {
            $this->view('events/show', $data);
        } else {
            $this->redirect('');
        }
    }
}
