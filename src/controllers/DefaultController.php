<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
class DefaultController extends AppController{
    private $petsitterRepository;
    public function index(){
        $this->render('dashboard');
    }

    public function dashboard() {
        $this->checkDashboard();
    }

    private function checkDashboard() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }

        $userId = $_SESSION['user_id'];
    error_log("Checking dashboard for user: $userId");

    $petsitterRepository = new PetsitterRepository();
    if ($petsitterRepository->isPetsitter($userId)) {
        error_log("Rendering petsitterDashboard for user: $userId");
        $this->render('petsitterDashboard');
    } else {
        error_log("Rendering userDashboard for user: $userId");
        $this->render('userDashboard');
    }
        
    }


    public function book(){
        $this->render('findAPetsitter');
    }
    public function signup() {
        $this->render('signup');
    }
    public function userDashboard(){
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "<script>window.location.href = '/login';</script>";
            exit();
        }
    
        $this->render('userDashboard');
    }
    // public function account() {
    //     session_start();
    //     if (!isset($_SESSION['user_id'])) {
    //         echo "<script>window.location.href = '/login';</script>";
    //         exit();
    //     }
    //     $this->render('manageAccountUser');
    // }
    

}