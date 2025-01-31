<?php
require_once 'AppController.php';
require_once __DIR__ .'/../models/Petsitter.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
class PetsitterController extends AppController {
    private $userRepository;
    private $petsitterRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->petsitterRepository = new PetsitterRepository();
    }
    public function isPetsitter($userId) {
        return $this->petsitterRepository->isPetsitter($userId);
    }
    public function becomePetsitter() {
        if (!$this->isPost()) {
            return $this->render('becomeAPetsitter');
        }
    
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $this->render('becomeAPetsitter', ['messages' => ['Please log in first']]);
        }
    
        $userData = [];
        $fieldsToUpdate = ['city', 'street', 'house_number', 'apartment_number', 'postal_code', 'phone'];
    
        foreach ($fieldsToUpdate as $field) {
            if (isset($_POST[$field]) && !empty($_POST[$field])) {
                $userData[$field] = $_POST[$field];
            }
        }
    
        $description = $_POST['description'] ?? '';
    
        $userUpdateResult = true;
        if (!empty($userData)) {
            $userUpdateResult = $this->userRepository->updateUserPartial($userId, $userData);
        }
    
        $petsitterResult = $this->petsitterRepository->createPetsitter($userId, $description);
    
        if ($userUpdateResult && $petsitterResult) {
            header("Location: /dashboardPetsitter");
            exit();
        } else {
            return $this->render('becomePetsitter', ['messages' => ['Registration failed. Please try again.']]);
        }
        
    }


    public function updatePetsitterProfile($userId, $data) {
        if(!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Something went wrong']);
        }
    
        $result = $this->petsitterRepository->updatePetsitter($_SESSION['user_id'], $_POST);
        
        if ($result) {
            header('Location: /manageAccount');
        } else {
            return $this->render('error', ['message' => 'Update failed']);
        }
    }
    
    public function updatePetsitterServices() {
        session_start();
        if (!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Unauthorized request']);
        }
    
        $userId = $_SESSION['user_id'];
        $data = [
            'is_dog_sitter' => in_array('dog', $_POST['pet_types'] ?? []),
            'is_cat_sitter' => in_array('cat', $_POST['pet_types'] ?? []),
            'is_rodent_sitter' => in_array('rodent', $_POST['pet_types'] ?? []),
            'care_at_owner_home' => in_array('care_at_owner_home', $_POST['services'] ?? []),
            'care_at_petsitter_home' => in_array('care_at_petsitter_home', $_POST['services'] ?? []),
            'dog_walking' => in_array('dog_walking', $_POST['services'] ?? []),
            'hourly_rate' => $_POST['hourly_rate'] ?? 0
        ];
    
        $result = $this->petsitterRepository->updatePetsitterServices($userId, $data);
    
        if ($result) {
            $_SESSION['success_message'] = 'Services updated successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to update services';
        }
        header('Location: /manageAccount');
        exit();
    }
    public function updateAvailability() {
        session_start();
        if (!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Unauthorized request']);
        }
    
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $isAvailable = (bool)$_POST['is_available'];

        error_log("Start Date: " . $startDate);
        error_log("End Date: " . $endDate);
        error_log("Is Available: " . ($isAvailable ? 'true' : 'false'));
    
        $dates = [];
        $current = new DateTime($startDate);
        $end = new DateTime($endDate);
        while ($current <= $end) {
            $dates[] = $current->format('Y-m-d');
            $current->modify('+1 day');
        }

        error_log("Generated dates: " . implode(', ', $dates));
    
        $petsitterId = $this->petsitterRepository->getPetsitterId($_SESSION['user_id']);
        $result = $this->petsitterRepository->updatePetsitterAvailability($petsitterId, $dates, $isAvailable);
    
        if ($result) {
            $_SESSION['success_message'] = 'Availability updated successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to update availability';
        }
    
        header('Location: /manageAccount');
        exit();
    }
    
    
}    