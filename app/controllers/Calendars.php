<?php 

namespace app\controllers;

class Calendars extends \app\controllers\Authentication {

	public function __construct() {
        $this->requireAdminLogin();

        $this->calendar_dao = $this->dao('Calendar');
        $this->event_dao = $this->dao('Event');
        $this->artist_dao = $this->dao('Artist');
        $this->seat_type_dao = $this->dao('SeatType');
        $this->place_event_dao = $this->dao('PlaceEvent');
        $this->event_seat_dao = $this->dao('EventSeat');
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

        $data = [   
                    'date' => $_POST['date'],
                    'id_event' => $_POST['id_event'],
                    'place_event' => $_POST['place_event'],
                    'event_seats' => $_POST['event_seats']
                ];
        $data['place_event']['description'] = trim($data['place_event']['description']);

        if (isset($_POST['id_artist_arr'])) {
            $data['id_artist_arr'] = $_POST['id_artist_arr'];
        }

        if ($this->isBeforeNow($data['date'])) {
            $data['errors']['date_is_before_now'] = "La fecha ya es pasada";
        }

        $event_seats_sum = 0;
        foreach ($data['event_seats'] as $value) {
            $event_seats_sum += $value['quantity'];
        }
        if ($event_seats_sum > $data['place_event']['capacity']) {
            $data['errors']['capacity_limit_reached'] = "Se excedió la capacidad máxima de asientos disponibles";                 
        }

        if (!empty($data['errors'])) {

            $this->index($data);

        } else {

            $calendar_data = [
                                'date' => $data['date'],
                                'id_artist_arr' => $data['id_artist_arr'],
                                'id_event' => $data['id_event']
                             ];

            $this->calendar_dao->create($calendar_data);

            $calendar_id = $this->calendar_dao->retrieveLastId();

            foreach ($data['event_seats'] as $value) {

                $event_seat_data = [
                                       'id_calendar' => $calendar_id,
                                       'id_seat_type' => $value['id_seat_type'],
                                       'quantity' => $value['quantity'],
                                       'price' => $value['price'],
                                       //ATENCION: Esto sólo es válido cuando se crea el nuevo objeto, NUNCA cuando se actualiza
                                       'remainder' => $value['quantity']
                                   ];

                $this->event_seat_dao->create($event_seat_data);
            }

            $place_event = [
                                'id_calendar' => $calendar_id,
                                'capacity' => $data['place_event']['capacity'],
                                'description' => $data['place_event']['description']
                           ];

            $this->place_event_dao->create($place_event);

            $this->redirect('calendars');
        }
    }

    public function update($id) {

        $this->redirectIfRequestIsNotPost('calendars');

        $data = [   
                    'id_calendar' => $id,
                    'date' => $_POST['date'],
                    'id_event' => $_POST['id_event'],
                    'place_event' => $_POST['place_event'],
                    'event_seats' => $_POST['event_seats']
                ];
        $data['place_event']['description'] = trim($data['place_event']['description']);

        if (isset($_POST['id_artist_arr'])) {
            $data['id_artist_arr'] = $_POST['id_artist_arr'];
        }

        if ($this->isBeforeNow($data['date'])) {
            $data['errors']['date_is_before_now'] = "La fecha ya es pasada";
        }

        $event_seats_sum = 0;

        foreach ($data['event_seats'] as $key => $value) {
            $event_seats_sum += $value['new_quantity'];

            //Se debe verificar que el remanente de asientos correspondientes a su tipo no sea menor a 0 previo a actualizar la nueva cantidad
            $remainder = $value['remainder'] + $value['new_quantity'] - $value['previous_quantity'];

            if ($remainder < 0) {
                $data['errors'][$key . '_remainder_err'] = "La cantidad de asientos restantes a la categoria $key se ha sobrepasado de cero.";
            }
        }

        if ($event_seats_sum > $data['place_event']['capacity']) {
            $data['errors']['capacity_limit_reached'] = "Se excedió la capacidad máxima de asientos disponibles";                 
        }

        if (!empty($data['errors'])) {

            $this->index($data);

        } else {

            $calendar_data = [
                                'id_calendar' => $id,
                                'date' => $data['date'],
                                'id_artist_arr' => $data['id_artist_arr'],
                                'id_event' => $data['id_event']
                             ];

            $this->calendar_dao->update($calendar_data);

            foreach ($data['event_seats'] as $value) {

                $remainder = $value['remainder'] + $value['new_quantity'] - $value['previous_quantity'];

                $event_seat_data = [
                                       'id_event_seat' => $value['id_event_seat'],
                                       'quantity' => $value['new_quantity'],
                                       'price' => $value['price'],
                                       'remainder' => $remainder
                                   ];

                $this->event_seat_dao->update($event_seat_data);
            }

            $place_event = [
                                'id_place_event' => $data['place_event']['id_place_event'],
                                'capacity' => $data['place_event']['capacity'],
                                'description' => $data['place_event']['description']
                           ];

            $this->place_event_dao->update($place_event);

            $this->redirect('calendars');

        }

    }

    public function edit($id) { 
        $data['calendar'] = $this->calendar_dao->retrieveById($id);
        $data['events'] = $this->event_dao->retrieveAll();
        $data['artists'] = $this->artist_dao->retrieveAll();
        $data['seat_types'] = $this->seat_type_dao->retrieveAll();
        $data['event_seats'] = $this->event_seat_dao->retrieveByCalendarId($id);
        
        if(isset($data['calendar'])) {
            $this->view('admin/calendars', $data);
        }
    }

	public function updates($id_calendar, $date, $eventId, $artistIdArray, $placeEventId, $placeEventAttributesArray, $eventSeatAttributesArray) {

		
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
        $this->calendar_dao->delete($id);
        $this->index();
    }

	/*Comprueba que la fecha introducida no sea pasada a la actual*/
	private function isBeforeNow($date) {
		return (strtotime($date) < strtotime('now'));
	}
}
?>