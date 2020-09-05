<?php

namespace app\controllers\admin;

use core\View;

class Sales extends \app\controllers\Authentication
{
    public function __construct()
    {
        $this->requireAdminLogin();

        $this->purchase_dao      = $this->dao('Purchase');
        $this->category_dao      = $this->dao('Category');
        $this->calendar_dao      = $this->dao('Calendar');
        $this->event_seat_dao    = $this->dao('EventSeat');
        $this->purchase_line_dao = $this->dao('PurchaseLine');
    }

    /**
     * Lista el total de ventas hasta el día de la fecha y permite seleccionar 
     * por fecha o categoría.
     * @return void
     */
    public function index()
    {
        $data['total_sales'] = $this->purchase_dao->retrieveTotal();
        $data['categories']  = $this->category_dao->retrieveAll();

        View::render('admin/sales', $data);
    }

    /**
     * Muestra el total de ventas hechas en una fecha específica
     * @param  $date La fecha del cual se quiere conocer la cantidad de ventas realizadas
     * @return void
     */
    public function byDate($date)
    {
        $data['total'] = 0;
        $data['date'] = $date;
        $data['purchases'] = $this->purchase_dao->retrieveByDate($date);

        foreach ($data['purchases'] as $purchase) {
            $data['total'] += (double)$purchase->getTotal();
        }

        View::render('admin/sales_by_date', $data);
    }

    /**
     * Muestra el total de ventas hechas según la categoría de evento.
     * @param  $id_category El ID de la categoría
     * @return void
     */
    public function byCategory($id_category)
    {
        $data['total'] = 0;
        $data['category_name'] = $this->category_dao->retrieveById($id_category)->getType();

        $data['purchase_lines'] = $this->purchase_line_dao->retrieveAll();

        foreach ($data['purchase_lines'] as $purchase_line) {
            $event_seat = $this->event_seat_dao->retrieveById($purchase_line->getEventSeatId());
            $calendar   = $this->calendar_dao->retrieveById($event_seat->getCalendarId());

            if ($calendar->getEvent()->getCategory()->getId() == $id_category) {
                $data['total'] += (double)$purchase_line->getPrice();
            }
        }

        View::render('admin/sales_by_category', $data);
    }
}
