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

    /**
     * Lista los asientos disponibles al calendario.
     * @param  $id_calendar El ID del calendario
     * @return void
     */
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

    /**
     * Muestra el tipo de asiento correspondiente al calendario y permite agregar 
     * al carro de compra determinada cantidad de asientos.
     * @param  $id_event_seat El ID del tipo de asiento
     * @return void
     */
    public function showSeat($id_event_seat)
    {
        $this->redirectIfRequestIsNotPost('/');
        $this->requireUserLogin();

        $data['event_seat'] = $this->event_seat_dao->retrieveById($id_event_seat);

        $calendar = $this->calendar_dao->retrieveById($data['event_seat']->getCalendarId());

        $data['event'] = $calendar->getEvent();
        $data['date']  = $calendar->getDate();

        View::render('calendars/show_seat', $data);
    }
}
