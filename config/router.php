<?php 
namespace config;

class Router {

    public function __construct()
    {
    }

    public static function direct(Request $request) {

        $controller = $request->getController() . 'Controller';

        $method = $request->getMethod();

        $parameters = $request->getParameters();

        $class = "controllers\\". $controller;

        $instance = new $class;

        if($_FILES) {
           $parameters[] = $_FILES;
       }

        if(!isset($parameters)) {
            call_user_func(array($instance, $method));
        } else {
            call_user_func_array(array($instance, $method), $parameters);
        }
    }
}

?>
