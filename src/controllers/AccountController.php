<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
class AccountController extends AppController {
    private $petRepository;
    private $userRepository;
    private $petsitterRepository;

    public function __construct() {
        parent::__construct();
        $this->petRepository = new PetRepository();
        $this->userRepository = new UserRepository();
        $this->petsitterRepository = new PetsitterRepository();
    }

    public function manageAccount() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login');
        }
        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);
        $isPetsitter = $this->petsitterRepository->isPetsitter($userId);
        $pets = $this->petRepository->getPetsByUserId($userId);

        $petsitter = null;
        $petsitterServices = null;
        if ($isPetsitter) {
            $petsitter = $this->petsitterRepository->getPetsitterByUserId($userId);
            $petsitterServices = $this->petsitterRepository->getPetsitterServices($userId);
        }
    
        return $this->render('manageAccount', [
            'user' => $user,
            'isPetsitter' => $isPetsitter,
            'pets' => $pets,
            'petsitter' => $petsitter,
            'petsitterServices' => $petsitterServices
        ]);
    }
    
}