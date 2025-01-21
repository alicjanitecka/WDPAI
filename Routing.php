<?php


require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
 require_once 'src/controllers/BookingController.php';
class Routing{
    public static $routes;
    public static function get($url, $controller){
        self::$routes[$url]=$controller;
    }


    public static function post($url, $controller){
        self::$routes[$url]=$controller;
    }


    public static function run($url){
        $segments = explode("/", $url);
        $action = $segments[0];  // Pierwsza część URL to akcja
        if(!array_key_exists($action, self::$routes)){
            die("Wrong url");
        }
        $controller = self::$routes[$action];
        $object = new $controller;
        
        // Sprawdzenie czy akcja istnieje w kontrolerze
        if (method_exists($object, $action)) {
            $object->$action();
        } else {
            die("Action $action not found in $controller");
        }
    }
}