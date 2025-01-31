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
            header('Location: /manageAccount');
            exit();
        }

        if ($this->isPost()) {
            $userId = $_SESSION['user_id'];
        

            $name = $_POST['name'] ?? '';
            $age = $_POST['age'] ?? 0;
            $petType = $_POST['pet_type'] ?? '';
            $breed = $_POST['breed'] ?? '';
            $additionalInfo = $_POST['additional_info'] ?? '';
    
            $pet = new Pet(
                null, 
                $userId,
                $name,
                $age,
                $petType,
                $breed,
                $additionalInfo
            );
    
            if ($this->petRepository->addPet($pet)) {
                header('Location: /manageAccount'); 
            } else {
                return $this->render('error', ['message' => 'Failed to add pet']);
            }
        }

        return $this->render('error', ['message' => 'Invalid request']);
    }

    public function updatePet() {
        session_start();
    
        if (!$this->isPost() || !isset($_SESSION['user_id'])) {
            error_log('Not a POST request or user not logged in');
            return $this->render('error', ['message' => 'Wrong request method']);
        }
    
            $petId = $_POST['id'] ?? null; 
    
            if (!$petId) {
                error_log('Pet ID is missing');
        return $this->render('error', ['message' => 'Pet ID is required']);
            }
    

            $name = $_POST['name'] ?? '';
            $age = $_POST['age'] ?? 0;
            $petType = $_POST['pet_type'] ?? '';
            $breed = $_POST['breed'] ?? '';
            $additionalInfo = $_POST['additional_info'] ?? '';
            $photoUrl = '../Public/img/default-pet.svg';

            if (empty($name) || empty($petType)) {
                error_log('Missing required fields');
                return $this->render('error', ['message' => 'Name and species are required']);
            }
            if (!in_array($petType, ['dog', 'cat', 'rodent'])) {
                error_log('Invalid pet type');
                return $this->render('error', ['message' => 'Invalid pet type']);
            }
            $pet = new Pet(
                $petId,
                $_SESSION['user_id'],
                $name,
                $age,
                $petType,
                $breed,
                $additionalInfo,
                $_POST['photo_url'] ?? '../Public/img/default-pet.svg'
            );

            $updateResult = $this->petRepository->updatePet($pet);
            if ($updateResult === false) {
                error_log('Failed to update pet in database');
                return $this->render('error', ['message' => 'Failed to update pet']);
            }

            header('Location: /manageAccount');
            exit();

    }
    public function deletePet() {
        session_start();
    
        if (!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Unauthorized request']);
        }
    
        try {
            $petId = $_POST['id'] ?? null;
    
            if (!$petId) {
                throw new Exception('Pet ID is required for deletion');
            }
    
            error_log("Attempting to delete pet with ID: " . $petId);
    
            if ($this->petRepository->deletePetById($petId)) {
                error_log("Pet with ID: " . $petId . " successfully deleted");
                header('Location: /manageAccount');
                exit();
            } else {
                throw new Exception('Failed to delete pet');
            }
        } catch (Exception $e) {
            error_log('Error deleting pet: ' . $e->getMessage());
            return $this->render('error', ['message' => 'Failed to delete pet']);
        }
    }
}
