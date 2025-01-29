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
    // public function dashboardPetsitter() {
    //     $this->render('petsitterDashboard');
    // }

    public function updatePetsitterProfile($userId, $data) {
        // session_start();
        if(!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Something went wrong']);
        }
    
        $result = $this->petsitterRepository->updatePetsitter($_SESSION['user_id'], $_POST);
        
        if ($result) {
            header('Location: /account');
        } else {
            return $this->render('error', ['message' => 'Update failed']);
        }
    }
    
    public function updatePetsitterServices() {
        if (!$this->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
    
        $userId = $_SESSION['user_id'];
        $data = $_POST;
    
        $result = $this->petsitterRepository->updatePetsitterServices($userId, $data);
    
        if ($result) {
            $_SESSION['success_message'] = 'Services updated successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to update services';
        }
        header('Location: /manageAccount');
        exit();
    }
    
}    