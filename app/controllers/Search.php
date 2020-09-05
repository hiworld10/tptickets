<?php

namespace app\controllers;

use app\utils\Flash;
use core\View;

class Search extends \core\Controller
{
    public function __construct()
    {
        $this->event_dao    = $this->dao('Event');
        $this->artist_dao   = $this->dao('Artist');
        $this->category_dao = $this->dao('Category');
    }

    /**
     * Devuelve el resultado de la búsqueda realizada, por string.
     * @param  string $string El string a buscar
     * @return void
     */
    public function index($string)
    {
        $data['events'] = $this->event_dao->retrieveActiveEventsByString($string);
        View::render('search/index', $data);
    }

    /**
     * Muestra las opciones avanzadas de búsqueda
     * @return void
     */
    public function advanced()
    {
        $data['artists'] = $this->artist_dao->retrieveAll();

        //Ordena los resultados por nombre
        usort($data['artists'], function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        $data['categories'] = $this->category_dao->retrieveAll();
        View::render('search/advanced', $data);
    }

    /**
     * Muestra resultados de búsqueda por artista.
     * @return void
     */
    public function byArtist()
    {
        $data['events'] = $this->event_dao->retrieveEventsByArtistId($_POST['id_artist']);
        View::render('search/index', $data);
    }

    /**
     * Muestra resultados de búsqueda por categoría de evento.
     * @return void
     */
    public function byCategory()
    {
        $data['events'] = $this->event_dao->retrieveActiveEventsByCategoryId($_POST['id_category']);
        View::render('search/index', $data);
    }

    /**
     * Muestra resultados de búsqueda por fecha.
     * @return void
     */
    public function byDate()
    {
        if (strtotime($_POST['date']) < strtotime('now')) {
            Flash::addMessage('Error: la fecha introducida ya es pasada.', Flash::WARNING);
            $this->advanced();
        } else {
            $data['events'] = $this->event_dao->retrieveEventsByDate($_POST['date']);
            View::render('search/index', $data);
        }
    }
}
