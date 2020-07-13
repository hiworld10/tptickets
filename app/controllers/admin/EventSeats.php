<?php

namespace app\controllers\admin;

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
}
