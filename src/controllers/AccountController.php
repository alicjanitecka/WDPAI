<?php

class AccountController extends AppController {
    private $petRepository;
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->petRepository = new PetRepository();
        $this->userRepository = new UserRepository();
    }

    public function updateUserProfile() {
        error_log('updateUserProfile called');
        error_log('POST data: ' . print_r($_POST, true));
        if (!$this->isPost()) {
            return $this->render('error', ['message' => 'Wrong request method']);
        }

        $userId = $_SESSION['user_id'];
        error_log('Updating user: ' . $userId);
        $this->userRepository->updateUser($userId, $_POST);
        
        http_response_code(200);
    }

    // public function addPet() {
    //     if (!$this->isPost()) {
    //         return $this->render('error', ['message' => 'Wrong request method']);
    //     }

    //     $pet = new Pet(
    //         $_SESSION['user_id'],
    //         $_POST['name'],
    //         $_POST['age'],
    //         $_POST['species'],
    //         $_POST['breed'],
    //         $_POST['additional_info']
    //     );

    //     $this->petRepository->addPet($pet);
    //     http_response_code(200);
    // }

    // public function updatePet() {
    //     // podobnie jak addPet, ale z UPDATE
    // }

    // public function deletePet() {
    //     if (!$this->isPost()) {
    //         return $this->render('error', ['message' => 'Wrong request method']);
    //     }

    //     $this->petRepository->deletePet($_POST['pet_id']);
    //     http_response_code(200);
    // }
    // public function getPets() {
    //     $pets = $this->petRepository->getPetsByUserId($_SESSION['user_id']);
    //     return $this->render('pets', ['pets' => $pets]);
    // }
    
}
