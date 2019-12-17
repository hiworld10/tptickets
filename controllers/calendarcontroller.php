<?php 
namespace controllers;
use config\Singleton;
use model\Calendar;
use model\EventSeat;
use dao\lists\CalendarDAO as List_CalendarDAO;
use dao\db\CalendarDAO as DB_CalendarDAO;
use controllers\EventController;
use controllers\ArtistController;
use controllers\PlaceEventController;
use controllers\SeatTypeController;
use controllers\EventSeatController;
use controllers\UserController;


class CalendarController {

	private $dao;
	private $eventController;
	private $placeEventController;
	private $artistController;
	private $seatTypeController;
	private $eventSeatController;
	private $userController;

	public function __construct() {
		$this->dao = new DB_CalendarDAO();
		$this->eventController = new EventController();
		$this->placeEventController = new PlaceEventController();
		$this->artistController = new ArtistController();
		$this->seatTypeController = new SeatTypeController();
		$this->eventSeatController = new EventSeatController();
		$this->userController = new UserController();
	}

	public function addCalendar($date, $eventId, $artistIdArray, $placeEventAttributesArray, $eventSeatAttributesArray) {

		
		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
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
				$this->getAll();
			}else
				{

			//insercion de calendario en bd
					$calendarAttributes= array("date"=>$date, "eventId"=> $eventId, "artistIdArray" => $artistIdArray);
					$this->dao->create($calendarAttributes);
			// guardo ultimo id de ultima instancia
					$calendarId= $this->dao->retrieveLastId();

					foreach ($eventSeatAttributesArray as $value) {
						$seatType= $this->seatTypeController->getSeatTypeById($value['seattypeid']);

							$this->eventSeatController->addEventSeat($calendarId, $seatType , $value['capacity'], $value['price']);
					
					}

					$this->placeEventController->addPlaceEvent($calendarId, $placeEventAttributesArray['capacity'],$placeEventAttributesArray['description']);

					$this->getAll();
			}	
		}
	}

	public function getCalendar($id) { 
		$calendar=$this->dao->retrieveById($id);
		$eventArray = $this->eventController->getAllSelect();
		$artistArray = $this->artistController->getAll();
		$seatTypeArray = $this->seatTypeController->getAllSelect();

		$eventSeatArray= $this->eventSeatController->getByCalendarId($id);
		
		if(isset($calendar)) {
			require ADMIN_VIEWS . '/admincalendar.php';
		}
	}

	public function getCalendarById($id) { 
		return $this->dao->retrieveById($id);

	}

	public function getAll() {
		/*Si el usuario no es admin, la controladora no permitira acceder a los datos.
		  Ver si es posible imprimir un mensaje de alerta advirtiendo que el usuario no
		  tiene permiso para acceder a la pagina. Aplicar esta comprobacion en los otros metodos*/
		if (!$this->userController->isUserAdmin()) {
			$this->userController->index();
		} else {
			$calendarArray = $this->dao->retrieveAll();
		    $eventArray = $this->eventController->getAllSelect();
		    $artistArray = $this->artistController->getAll();
		    $seatTypeArray = $this->seatTypeController->getAllSelect();

		    require ADMIN_VIEWS. '/admincalendar.php';
		}
		
	}

	public function deleteCalendar($id){
		$this->dao->delete($id);
		$this->getAll();
	}

	public function updateCalendar($id_calendar, $date, $eventId, $artistIdArray, $placeEventId, $placeEventAttributesArray, $eventSeatAttributesArray) {

		
		if ($this->isBeforeNow($date)) {
			echo "ERROR: la fecha ya es pasada.";
			$this->getAll();
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
				$this->getAll();
			} else {

			//Update de calendario en bd
				$calendarAttributes= array("id_calendar"=>$id_calendar, "date"=>$date, "eventId"=> $eventId, "artistIdArray" => $artistIdArray);
				$this->dao->update($calendarAttributes);
		

				foreach ($eventSeatAttributesArray as $value) {
					$seatType = $this->seatTypeController->getSeatTypeById($value['idseattype']);

					$this->eventSeatController->updateEventSeat($value['ideventseat'], $id_calendar, $seatType, $value['capacity'], $value['price']);

				}

				$this->placeEventController->updatePlaceEvent($placeEventId, $id_calendar, $placeEventAttributesArray['capacity'],$placeEventAttributesArray['description']);

				$this->getAll();
			}	
		}

	}

	public function getAllSelect(){
		return $this->dao->retrieveAll();
	}

	/*Comprueba que la fecha introducida no sea pasada a la actual*/
	public function isBeforeNow($date) {
		return (strtotime($date) < strtotime('now'));
	}

    public function getCalendarsByString($string) {
        return $this->dao->retrieveCalendarsByString($string);
    }
	
}
?>