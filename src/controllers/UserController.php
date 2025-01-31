<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
require_once __DIR__ . '/../repository/PetRepository.php';
require_once __DIR__ . '/../controllers/PetsitterController.php';

class UserController extends AppController {
    private $userRepository;
    private $petsitterRepository;
    private $petRepository;
    private $petsitterController;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->petsitterRepository = new PetsitterRepository();
        $this->petRepository = new PetRepository();
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
            $this->updateUserProfile($userId, $_POST);
        }

        if (isset($_POST['description'])) {
            $this->petsitterController->updatePetsitterProfile($userId, $_POST);
        }

        header('Location: /manageAccount');
        exit();
    }

    private function updateUserProfile($userId, $data) {
        if(!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Something went wrong']);
        }
    
        $result = $this->userRepository->updateUser($_SESSION['user_id'], $_POST);
        
        if ($result) {
            header('Location: /manageAccount');
        } else {
            return $this->render('error', ['message' => 'Update failed']);
        }
    }

    
}
