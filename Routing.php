<?php


require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/VisitController.php';
 require_once 'src/controllers/PetController.php';
 require_once 'src/controllers/UserController.php';
 require_once 'src/controllers/PetsitterController.php';
 require_once 'src/controllers/SearchController.php';
class Routing{
    public static $routes;
    public static function get($url, $controller){
        self::$routes[$url]=$controller;
    }


    public static function post($url, $controller){
        self::$routes[$url]=$controller;
    }


    public static function run($url){
        if ($url === '') {
            $url = 'dashboard';
        }
        $segments = explode("/", $url);
        $action = $segments[0];  // Pierwsza część URL to akcja
        if(!array_key_exists($action, self::$routes)){
            die("Wrong url");
        }
        $controller = self::$routes[$action];
        $object = new $controller;
        
        if (method_exists($object, $action)) {
            $object->$action();
        } else {
            die("Action $action not found in $controller");
        }
    }
}