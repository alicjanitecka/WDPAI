<?php
require_once 'src/models/Booking.php';
 class BookingController extends AppController {
     public function book() {
        //  echo "Booking request received";
         $this->render('findAPetsitter');
     }
//     private function render($view) {
//         $path =  __DIR__ .'../../views/' . $view . '.php';
//         if (file_exists($path)) {
//             include $path;
//         } else {
//             die("View $view not found");
//         }
//     }
 }