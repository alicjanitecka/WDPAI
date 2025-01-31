<?php


require 'Routing.php';


$path=trim($_SERVER['REQUEST_URI'], '/');
$path=parse_url($path, PHP_URL_PATH);


Routing::get('', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('signup', 'DefaultController');
Routing::get('login', 'SecurityController');
Routing::get('signup', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('manageAccount', 'UserController');
Routing::get('becomePetsitter', 'PetsitterController');
Routing::get('myVisits', 'VisitController');

Routing::post('confirmVisit', 'VisitController');
Routing::post('cancelVisit', 'VisitController');
Routing::post('becomePetsitter', 'PetsitterController');
Routing::post('login', 'SecurityController');
Routing::post('signup', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('updatePet', 'PetController');
Routing::post('deletePet', 'PetController');
Routing::post('addPet', 'PetController');
Routing::post('updateAccount', 'UserController');
Routing::post('updatePetsitterServices', 'PetsitterController');
Routing::post('updateAvailability', 'PetsitterController');
Routing::post('search', 'SearchController');
Routing::post('book', 'VisitController');


Routing::run($path);