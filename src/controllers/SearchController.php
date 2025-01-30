<?php

class SearchController extends AppController {
    private $petsitterRepository;
    private $petRepository;

    public function __construct() {
        parent::__construct();
        $this->petsitterRepository = new PetsitterRepository();
        $this->petRepository = new PetRepository();
    }

    // public function search() {
    //     $startDate = $_GET['start_date'];
    //     $endDate = $_GET['end_date'];
    //     $serviceType = $_GET['service_type'] ?? null;
    //     $petTypes = $_GET['pet_types'] ?? [];

    //     $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    //     $perPage = 15;

    //     $petsitters = $this->petsitterRepository->searchPetsitters($startDate, $endDate, $serviceType, $petTypes, $page, $perPage);
    //     $totalPetsitters = $this->petsitterRepository->countSearchResults($startDate, $endDate, $serviceType, $petTypes);

    //     $this->render('findAPetsitter', [
    //         'petsitters' => $petsitters,
    //         'startDate' => $startDate,
    //         'endDate' => $endDate,
    //         'serviceType' => $serviceType,
    //         'petTypes' => $petTypes,
    //         'currentPage' => $page,
    //         'totalPages' => ceil($totalPetsitters / $perPage)
    //     ]);
    // }
    public function search() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $results = $this->petsitterRepository->search([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'care_type' => $data['care_type'],
                'pets' => $data['pets'] ?? []
            ]);
    
            header('Content-Type: application/json');
            echo json_encode($results);
            exit;
        }
    
        $userId = $_SESSION['user_id'] ?? null;
        $userPets = $this->petRepository->getPetsByUserId($userId);
        $this->render('dashboard', ['userPets' => $userPets]);
    }
    
    
    
    private function isAjax() {
        return isset($_SERVER['HTTP-X-REQUESTED-WITH']) && 
               strtolower($_SERVER['HTTP-X-REQUESTED-WITH']) == 'xmlhttprequest';
    }
    
}
