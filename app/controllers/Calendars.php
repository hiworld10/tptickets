<?php 

namespace app\controllers;


class Calendars extends \core\Controller
{
    public function __construct()
    {
        $this->event_seat_dao = $this->dao('EventSeat');
        $this->calendar_dao = $this->dao('Calendar');
    }

    public function listSeats($id)
    {
        $data['event_seats'] = [];
        $results = $this->event_seat_dao->retrieveByCalendarId($id);

        foreach ($results as $event_seat) {
            if ($event_seat->getRemainder() > 0) {
                $data['event_seats'][] = $event_seat;
            }
        }

        echo '<pre>';
        print_r($data['event_seats']);
        echo '</pre>';
    }
}

 ?>