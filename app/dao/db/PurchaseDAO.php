<?php

namespace app\dao\db;

class PurchaseDAO
{

    public function __construct()
    {
        if (!isset($_SESSION['tptickets_items']) || !isset($_SESSION['tptickets_subtotal'])) {
            $_SESSION['tptickets_items']    = [];
            $_SESSION['tptickets_subtotal'] = 0;
        }
    }

    public function addNewLineInSession($data)
    {
        $subtotal = $data['price'] * $data['amount'];

        $_SESSION['tptickets_items'][] = [
            'id_event_seat' => $data['id_event_seat'],
            'amount'        => $data['amount'],
            'price'         => $data['price'],
            'subtotal'      => $subtotal,
            'event_name'    => $data['event_name'],
            'date'          => $data['date'],
        ];
        $_SESSION['tptickets_subtotal'] += $subtotal;

        return !empty($_SESSION['tptickets_items']) ? true : false;
    }

}
