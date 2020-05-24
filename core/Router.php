<?php 

namespace core;
/**
 * Main front controller for the MVC. Routes the provided URL and calls the appropriate controller and method.
 */
class Router {

    public function __construct(Request $request) {

        $controller = $request->getController();
        $controller = $this->convertToStudlyCaps($controller);
        /**
         * If admin parameter from Request is true, the namespace will include the 'admin' directory in the controllers directory
         */
        if ($request->getAdmin() == true) {
            $controller = "\app\controllers\admin\\" . $controller;
        } else {
            $controller = "app\controllers\\" . $controller;
        }

        if (class_exists($controller)) {
            $instance = new $controller;
        } else {
            die("Error: Controller '" . $controller . "' does not exist.");
        }

        $method = $request->getMethod();
        $method = $this->convertToCamelCase($method);

        if (is_callable([$controller, $method])) {
            $parameters = $request->getParameters();

            if($_FILES) {
               $parameters[] = $_FILES;
            }

            if(!isset($parameters)) {
                call_user_func(array($instance, $method));
            } else {
                call_user_func_array(array($instance, $method), $parameters);
            }
        } else {
            die("Error: Method '" . $method . "' in Controller '" . $controller . "' does not exist or is not accessible.");
        }
    }

    /**
     * Convierte en camel case el string correspondiente a la funcion de la controladora a llamar
     * 
     * @param  string
     * @return string
     */
    private function convertToCamelCase($string) {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Capitaliza la inicial de cada caracter posterior a un '-' del string correspondiente a la funcion de la controladora a llamar. Se utiliza en conjunto con la funcion convertToCamelCase().
     *
     * De este modo, en el URL se podra llamar al metodo deseado separando palabras con un '-'. Ej: 'artists/get-all'
     * 
     * @param  string
     * @return string
     */
    private function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', '', $string)));
    }
}

 ?> 
