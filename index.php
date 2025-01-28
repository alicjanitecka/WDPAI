<?php


require 'Routing.php';


$path=trim($_SERVER['REQUEST_URI'], '/');
$path=parse_url($path, PHP_URL_PATH);


Routing::get('', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
// Routing::get('userDashboard', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('signup', 'DefaultController');
Routing::get('login', 'SecurityController');
Routing::get('signup', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('manageAccount', 'AccountController');

Routing::get('becomePetsitter', 'PetsitterController');
// Routing::get('dashboardPetsitter', 'PetsitterController');

Routing::post('updateUserProfile', 'UserController');
Routing::post('updatePetsitterProfile', 'PetsitterController');
Routing::post('becomePetsitter', 'PetsitterController');
Routing::post('login', 'SecurityController');
Routing::post('book', 'BookingController');
Routing::post('signup', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('updatePet', 'PetController');
Routing::post('deletePet', 'PetController');
Routing::post('addPet', 'PetController');
Routing::post('updateUserProfile', 'UserController');

Routing::run($path);