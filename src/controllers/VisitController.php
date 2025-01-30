<?php

require_once __DIR__ . '/../repository/VisitRepository.php';

class VisitController extends AppController {
    private $visitRepository;

    public function __construct() {
        parent::__construct();
        parent::__construct();
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->visitRepository = new VisitRepository();
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