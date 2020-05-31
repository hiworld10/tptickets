<?php 

namespace app\controllers;

use config\Singleton;
use app\models\Calendar;
use app\models\EventSeat;
use app\dao\lists\CalendarDAO as List_CalendarDAO;
use app\dao\db\CalendarDAO as DB_CalendarDAO;
use app\controllers\Events;
use app\controllers\Artists;
use app\controllers\PlaceEvents;
use app\controllers\SeatTypes;
use app\controllers\EventSeats;
use app\controllers\Users;


class Calendars extends \app\controllers\Authentication {

	private $dao;
	private $eventController;
	private $placeEventController;
	private $artistController;
	private $seatTypeController;
	private $eventSeatController;
	private $userController;

	public function __construct() {
        $this->requireAdminLogin();
		$this->dao = new DB_CalendarDAO();
		$this->eventController = new Events();
		$this->placeEventController = new PlaceEvents();
		$this->artistController = new Artists();
		$this->seatTypeController = new SeatTypes();
		$this->eventSeatController = new EventSeats();
		$this->userController = new Users();

        $this->calendar_dao = $this->dao('Calendar');
        $this->event_dao = $this->dao('Event');
        $this->artist_dao = $this->dao('Artist');
        $this->seat_type_dao = $this->dao('SeatType');
	}

    public function index($data = []) {
        
        $data['calendars'] = $this->calendar_dao->retrieveAll();
        $data['events'] = $this->event_dao->retrieveAll();
        $data['artists'] = $this->artist_dao->retrieveAll();
        $data['seat_types'] = $this->seat_type_dao->retrieveAll();

        $this->view('admin/calendars', $data);
    }

    public function add() {
        $this->redirectIfRequestIsNotPost('calendars');

        if ($this->isBeforeNow($_POST['date'])) {
            $data['errors']['date_is_before_now'] = "La fecha ya es pasada";
        }

        $event_seats_sum = 0;
        foreach ($_POST['eventSeat'] as $value) {
            $event_seats_sum += $value['capacity'];
        }
        if ($event_seats_sum > $_POST['placeEvent']['capacity']) {
            $data['errors']['capacity_limit_reached'] = "Se excedió la capacidad máxima de asientos disponibles";                 
        }

        if (!empty($data['errors'])) {
            $this->index($data);
        }

        echo "Exito xd";
    }

	public function adds($date, $eventId, $artistIdArray, $placeEventAttributesArray, $eventSeatAttributesArray) {

		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->index();
		} else {
			$eventSeatSum= 0;
			//Recorro eventSeat y guardo sus capacidades para sumarlas en una variable
			//para su comprobacion
			foreach ($eventSeatAttributesArray as $value) {
				$eventSeatSum += $value['capacity'];
			}

			if($eventSeatSum > $placeEventAttributesArray['capacity'])
			{
				echo "ERROR: La capacidad total fue excedida.";
				$this->index();
			}else
				{

			//insercion de calendario en bd
					$calendarAttributes= array("date"=>$date, "eventId"=> $eventId, "artistIdArray" => $artistIdArray);
					$this->dao->create($calendarAttributes);
			// guardo ultimo id de ultima instancia
					$calendarId= $this->dao->retrieveLastId();

					foreach ($eventSeatAttributesArray as $value) {
						$seatType= $this->seatTypeController->get($value['seattypeid']);

							$this->eventSeatController->addEventSeat($calendarId, $seatType , $value['capacity'], $value['price']);
					
					}

					$this->placeEventController->addPlaceEvent($calendarId, $placeEventAttributesArray['capacity'],$placeEventAttributesArray['description']);

					$this->index();
			}	
		}
	}

	public function getById($id) { 
		return $this->dao->retrieveById($id);

	}

    public function getByString($string) {
        return $this->dao->retrieveCalendarsByString($string);
    }

    public function getAll() {
        return $this->dao->retrieveAll();
    }

    public function edit($id) { 
        $calendar = $this->dao->retrieveById($id);
        $eventArray = $this->eventController->getAll();
        $artistArray = $this->artistController->getAll();
        $seatTypeArray = $this->seatTypeController->getAll();
        $eventSeatArray = $this->eventSeatController->getByCalendarId($id);
        
        if(isset($calendar)) {
            require ADMIN_VIEWS . '/admincalendar.php';
        }
    }

	public function update($id_calendar, $date, $eventId, $artistIdArray, $placeEventId, $placeEventAttributesArray, $eventSeatAttributesArray) {

		
		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->index();
		} else {
			$eventSeatSum= 0;
			//Recorro eventSeat y guardo sus capacidades para sumarlas en una variable
			//para su comprobacion
			foreach ($eventSeatAttributesArray as $value) {
				$eventSeatSum += $value['capacity'];
			}

			if($eventSeatSum > $placeEventAttributesArray['capacity'])
			{
				echo "ERROR: La capacidad total fue excedida.";
				$this->index();
			} else {

			//Update de calendario en bd
				$calendarAttributes= array("id_calendar"=>$id_calendar, "date"=>$date, "eventId"=> $eventId, "artistIdArray" => $artistIdArray);
				$this->dao->update($calendarAttributes);
		

				foreach ($eventSeatAttributesArray as $value) {
					$seatType = $this->seatTypeController->get($value['idseattype']);

					$this->eventSeatController->updateEventSeat($value['ideventseat'], $id_calendar, $seatType, $value['capacity'], $value['price']);

				}

				$this->placeEventController->updatePlaceEvent($placeEventId, $id_calendar, $placeEventAttributesArray['capacity'],$placeEventAttributesArray['description']);

				$this->index();
			}	
		}

	}

    public function delete($id) {
        $this->dao->delete($id);
        $this->index();
    }

	/*Comprueba que la fecha introducida no sea pasada a la actual*/
	private function isBeforeNow($date) {
		return (strtotime($date) < strtotime('now'));
	}
}
?>