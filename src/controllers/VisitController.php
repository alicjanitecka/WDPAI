<?php

require_once __DIR__ . '/../repository/VisitRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';

class VisitController extends AppController {
    private $visitRepository;
    private $userRepository;
    private $petsitterRepository;
    public function __construct() {
        parent::__construct();
        parent::__construct();
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->visitRepository = new VisitRepository();
        $this->userRepository = new UserRepository();
        $this->petsitterRepository = new PetsitterRepository();
    }
    public function myVisits() {
        $userId = $_SESSION['user_id'];
        $isPetsitter = $this->petsitterRepository->isPetsitter($userId);
        
        if ($isPetsitter) {
            $visits = $this->visitRepository->getVisitsByPetsitterId($userId);
        } else {
            $visits = $this->visitRepository->getVisitsByUserId($userId);
        }
        
        $this->render('myVisits', [
            'visits' => $visits,
            'isPetsitter' => $isPetsitter
        ]);
    }
    
    public function confirmVisit() {
        if (!$this->isAjax()) {
            return;
        }
    
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->visitRepository->updateVisitStatus($data['visit_id'], true, false);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function cancelVisit() {
        if (!$this->isAjax()) {
            return;
        }
    
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->visitRepository->updateVisitStatus($data['visit_id'], false, true);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    

    public function book() {
        header('Content-Type: application/json');
        
        try {
            if (!$this->isAjax()) {
                throw new Exception('Not an AJAX request');
            }
    
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                throw new Exception('Invalid request data');
            }
    
            $this->visitRepository->createVisit([
                'user_id' => $_SESSION['user_id'],
                'petsitter_id' => $data['petsitter_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'care_type' => $data['care_type'],
                'pets' => $data['pets']
            ]);
    
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
    
    private function isAjax() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }
    
    
}