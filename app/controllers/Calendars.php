<?php

namespace app\controllers;

use core\View;

class Calendars extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->calendar_dao   = $this->dao('Calendar');
        $this->event_seat_dao = $this->dao('EventSeat');
    }

    public function listSeats($id_calendar)
    {
        $calendar            = $this->calendar_dao->retrieveById($id_calendar);
        $data['event_name']  = $calendar->getEvent()->getName();
        $data['date']        = $calendar->getDate();
        $data['event_seats'] = [];

        foreach ($calendar->getEventSeat() as $event_seat) {
            if ($event_seat->getRemainder() > 0) {
                $data['event_seats'][] = $event_seat;
            }
        }

        View::render('calendars/list_seats', $data);
    }

    public function showSeat($id_event_seat)
    {
        $this->redirectIfRequestIsNotPost('/');
        $this->requireUserLogin();

        $data['event_seat'] = $this->event_seat_dao->retrieveById($id_event_seat);

        $calendar = $this->calendar_dao->retrieveById($data['event_seat']->getCalendarId());

        $data['event_name'] = $calendar->getEvent()->getName();
        $data['date']       = $calendar->getDate();

        View::render('calendars/show_seat', $data);
    }
}
