<?php 

namespace app\controllers;

class Calendars extends \core\Controller
{
    public function __construct()
    {
        $this->calendar_dao = $this->dao('Calendar');
    }

    public function listSeats($id_calendar)
    {
        $calendar = $this->calendar_dao->retrieveById($id_calendar);
        $data['event_name'] = $calendar->getEvent()->getName();
        $data['date'] = $calendar->getDate();
        $data['event_seats'] = [];

        foreach ($calendar->getEventSeat() as $event_seat) {
            if ($event_seat->getRemainder() > 0) {
                $data['event_seats'][] = $event_seat;
            }
        }

        $this->view('calendars/list_seats', $data);
    }
}

 ?>