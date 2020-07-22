<?php

namespace app\controllers;

use core\View;

class Events extends \core\Controller
{
    public function __construct()
    {
        $this->calendar_dao = $this->dao('Calendar');
    }

    public function show($id_event)
    {
        $data['calendars'] = $this->calendar_dao->retrieveByEventId($id_event);
        if (!empty($data['calendars'])) {
            View::render('events/show', $data);
        } else {
            $this->redirect('/');
        }
    }
}
