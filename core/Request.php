<?php 

namespace core;

class Request
{
    private $controller;
    private $method;
    private $parameters;
    private $admin = false;

    public function __construct() {

        /**
        * Obtengo la url en formato de string
        */
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

        /**
        * La descompongo en un array
        */
        $urlToArray = explode("/", $url);

        /**
        * Elimino espacios vacios en el caso que los haya
        */
        $urlArray = array_filter($urlToArray);
        /**
         * Si el array tiene elementos, el primero lo guardamos en controller, si no, guardamos Home como controller por defecto
         */
        if(empty($urlArray)) {
           $this->controller = 'Home';
        } else {
            /**
             * Si el string en el primer elemento es 'admin', la propiedad $admin se vuelve true. Esto hara que el Router acceda a controladoras de uso exclusivo de un usuario con privilegios de administrador.
             */
            if ($urlArray[0] == 'admin') {
                $this->admin = true;
                array_shift($urlArray);
                $this->controller = ucwords(array_shift($urlArray));
            } else {
                $this->controller = ucwords(array_shift($urlArray));   
            }
        }

        /**
        * Si el array tiene elementos, el primero lo guardamos en method, si no, guardamos index como method por defecto
        */
        if(empty($urlArray)) {
            $this->method = 'index';
        } else {
            $this->method = array_shift($urlArray);
        }

        /**
         * Si la petición es GET y el array aún tiene datos, se guardan en parameters, si no, se guardan lo que viene como $_POST
        */
        $requestMethod = $this->getRequestMethod();

        if($requestMethod == 'GET') {
            //Estas instrucciones NO permiten almacenar el contenido de GET obtenido de formularios. Si el dato es introducido en el url, lo almacenamos asi.
            if(!empty($urlArray)) {
                $this->parameters = $urlArray;
            }
            //Sino, guardamos en el atributo 'parameters' el contenido 
            //de la variable global $_GET.
            else {
                $this->parameters = $_GET;
                //Y desligamos la clave 'url' ya que no es necesaria
                unset($this->parameters['url']);                
            }
        } else {
            $this->parameters = $_POST;
        }   
    }

    /**
    * Devuelve el método HTTP
    * con el que se hizo el
    * Request
    *
    * @return String
    */
    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
    * Devuelve el controlador
    *
    * @return String
    */
    public function getController() {
        return $this->controller;
    }

    /**
    * Devuelve el método
    *
    * @return String
    */
    public function getMethod() {
        return $this->method;
    }

    /**
    * Devuelve los atributos
    *
    * @return Array
    */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Devuelve el boolean de $admin
     * 
     * @return [type] [description]
     */
    public function getAdmin() {
        return $this->admin;
    }
}
