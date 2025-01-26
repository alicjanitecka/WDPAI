<?php


require_once 'AppController.php';
require_once __DIR__ .'/../models/Pet.php';
require_once __DIR__ . '/../repository/PetRepository.php';


class PetController extends AppController {
    private $petRepository;

    public function __construct() {
        parent::__construct();
        $this->petRepository = new PetRepository();
    }

    public function addPet() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
        header('Location: /account');
        exit();
    }
    
        if ($this->isPost()) {
            
            $pet = new Pet(
                $_SESSION['user_id'],
                $_POST['name'],
                $_POST['age'],
                $_POST['species'],
                $_POST['breed'],
                $_POST['additional_info']
            );
            
            $this->petRepository->addPet($pet);
        }
        
        header('Location: /account');
        exit();
    }
    

    // public function getPets() {
    //     $userId = $_SESSION['user_id'];
    //     $pets = $this->petRepository->getPetsByUserId($userId);
        
    //     return $this->render('manageAccountUser', [
    //         'pets' => $pets
    //     ]);
    // }
    public function account() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login');
        }
        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($_SESSION['user_id']);
        $userId = $_SESSION['user_id'];
        $pets = $this->petRepository->getPetsByUserId($userId);
        
        if ($pets === null) {
            $pets = [];
        }
        
        return $this->render('manageAccountUser', [
            'pets' => $pets,
            'userData' => $user
        ]);
    }
    
    public function updatePet() {
        error_log('updatePet called');
        error_log('POST data: ' . print_r($_POST, true));
        
        if (!$this->isPost()) {
            error_log('Not a POST request');
            return $this->render('error', ['message' => 'Wrong request method']);
        }
    
        try {
            $pet = new Pet(
                $_SESSION['user_id'],
                $_POST['name'],
                $_POST['age'],
                $_POST['species'],
                $_POST['breed'],
                $_POST['additional_info'],
                $_POST['photo_url'] ?? '../Public/img/default-pet.svg'
            );
            $this->petRepository->updatePet($pet);
            error_log('Pet updated successfully');
            http_response_code(200);
        } catch (Exception $e) {
            error_log('Error updating pet: ' . $e->getMessage());
            http_response_code(500);
        }
    }
    
}
