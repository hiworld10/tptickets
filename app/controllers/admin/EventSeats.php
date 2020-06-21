<?php

namespace app\controllers\admin;

use app\models\EventSeat;

class EventSeats extends \app\controllers\Authentication
{

    public function __construct()
    {
        $this->requireAdminLogin();

        $this->event_seat_dao = $this->dao('EventSeat');
        $this->seat_type_dao  = $this->dao('SeatType');
    }

    public function index()
    {
        $data['event_seats'] = $this->event_seat_dao->retrieveAll();
        //$seatTypeArray = $this->seat_type_dao->retrieveAll();
        $this->view('admin/event_seats', $data);
    }

    public function addEventSeat($calendarId, $seatType, $availableSeats, $price)
    {
        $remainder = $availableSeats;
        $eventSeat = new EventSeat(null, $calendarId, $seatType, $availableSeats, $price, $remainder);
        $this->dao->create($eventSeat);
    }

    public function addEventSeatAndView($calendarId, $seatType, $availableSeats, $price)
    {
        $remainder = $availableSeats;
        $eventSeat = new EventSeat(null, $calendarId, $seatType, $availableSeats, $price, $remainder);
        $this->dao->create($eventSeat);
        $this->getAll();
    }

    public function getEventSeat($id)
    {
        $eventSeat     = $this->dao->retrieveById($id);
        $seatTypeArray = $this->seatTypeController->getAll();
        if (isset($eventSeat) && isset($calendarArray) && isset($seatTypeArray)) {
            require ADMIN_VIEWS . '/admineventseat.php';
        }
    }

    public function getAllSelect()
    {
        return $this->dao->retrieveAll();
    }

    public function deleteEventSeat($id)
    {
        $this->dao->delete($id);
        $this->getAll();
    }

    public function updateEventSeat($id, $calendarId, $seatType, $availableSeats, $price)
    {
        $remainder = $availableSeats;

        $updatedEventSeat = new EventSeat($id, $calendarId, $seatType, $availableSeats, $price, $remainder);

        $this->dao->update($updatedEventSeat);
    }

    public function getByCalendarId($idCalendar)
    {
        return $this->dao->retrieveByCalendarId($idCalendar);
    }
}
