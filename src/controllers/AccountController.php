<?php

require_once 'AppController.php';
require_once 'UserController.php';
require_once 'PetsitterController.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
require_once __DIR__ . '/../repository/PetRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class AccountController extends AppController {
    private $petRepository;
    private $userRepository;
    private $petsitterRepository;
    private $userController;
    private $petsitterController;

    public function __construct() {
        parent::__construct();
        $this->petRepository = new PetRepository();
        $this->userRepository = new UserRepository();
        $this->petsitterRepository = new PetsitterRepository();
        $this->userController = new UserController();
        $this->petsitterController = new PetsitterController();
  
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
        $availabilities = null;
        
        if ($isPetsitter) {
            $petsitterId = $this->petsitterRepository->getPetsitterId($userId);
            $petsitter = $this->petsitterRepository->getPetsitterByUserId($userId);
            $petsitterServices = $this->petsitterRepository->getPetsitterServices($userId);
            if ($petsitterId) {
                $availabilities = $this->petsitterRepository->getPetsitterAvailability($petsitterId);
            }
        }
    
        return $this->render('manageAccount', [
            'user' => $user,
            'isPetsitter' => $isPetsitter,
            'pets' => $pets,
            'petsitter' => $petsitter,
            'petsitterServices' => $petsitterServices,
            'availabilities' => $availabilities
        ]);
    }
    
    public function updateAccount() {
        session_start();
        if (!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Something went wrong']);
        }

        $userId = $_SESSION['user_id'];

        if (isset($_POST['first_name']) || isset($_POST['last_name']) || isset($_POST['phone']) || 
            isset($_POST['city']) || isset($_POST['postal_code']) || isset($_POST['street']) || 
            isset($_POST['house_number']) || isset($_POST['apartment_number'])) {

            $this->userController->updateUserProfile($userId, $_POST);
        }

        if (isset($_POST['description'])) {
            $this->petsitterController->updatePetsitterProfile($userId, $_POST);
        }

        header('Location: /manageAccount');
        exit();
    }
}