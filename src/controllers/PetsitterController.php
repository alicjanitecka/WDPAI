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
    public function dashboardPetsitter() {
        $this->render('petsitterDashboard');
    }
    
}    