<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
class DefaultController extends AppController{
    private $petsitterRepository;
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->petsitterRepository = new PetsitterRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(){
        $this->render('dashboard');
    }

    // public function dashboard() {
    //     $this->checkDashboard();
    // }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login');
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);
        $isPetsitter = $this->petsitterRepository->isPetsitter($userId);

        return $this->render('dashboard', [
            'user' => $user,
            'isPetsitter' => $isPetsitter
        ]);
    }


    public function book(){
        $this->render('findAPetsitter');
    }
    public function signup() {
        $this->render('signup');
    }
    // public function userDashboard(){
    //     session_start();
    //     if (!isset($_SESSION['user_id'])) {
    //         echo "<script>window.location.href = '/login';</script>";
    //         exit();
    //     }
    
    //     $this->render('dashboard');
    // }
    // public function account() {
    //     session_start();
    //     if (!isset($_SESSION['user_id'])) {
    //         echo "<script>window.location.href = '/login';</script>";
    //         exit();
    //     }
    //     $this->render('manageAccountUser');
    // }
    

}