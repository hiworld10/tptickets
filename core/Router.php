<?php 

namespace core;

use app\utils\StringUtils;

/**
 * Main front controller for the MVC. Routes the provided URL and calls the appropriate controller and method.
 */
class Router {

    public function __construct(Request $request) {

        $controller = $request->getController();
        $controller = StringUtils::convertToStudlyCaps($controller);
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
            throw new \Exception("Error: Controller '" . $controller . "' does not exist.");
        }

        $method = $request->getMethod();
        $method = StringUtils::convertToCamelCase($method);

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
            throw new \Exception("Method '" . $method . "' in Controller '" . $controller . "' does not exist or is not accessible.");
        }
    }
}

 ?> 
