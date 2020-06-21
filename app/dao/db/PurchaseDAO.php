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

    public function removeLineInSession($id_event_seat)
    {
        $deleted = false;

        foreach ($_SESSION['tptickets_items'] as $key => $value) {

            if ($id_event_seat == $value['id_event_seat']) {
                $_SESSION['tptickets_subtotal'] -= $value['subtotal'];

                unset($_SESSION['tptickets_items'][$key]);

                $deleted = true;

                break;
            }
        }

        return $deleted;
    }

    public function removeAllLinesInSession()
    {
        $deleted = false;

        unset($_SESSION['tptickets_items']);

        if (!isset($_SESSION['tptickets_items'])) {
            $_SESSION['tptickets_subtotal'] = 0;

            $deleted = true;
        }

        return $deleted;
    }

    public function getAllLinesInSession()
    {
        return [
            'items'    => $_SESSION['tptickets_items'],
            'subtotal' => $_SESSION['tptickets_subtotal'],
        ];
    }
}
