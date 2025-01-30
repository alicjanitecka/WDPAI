<?php

class SearchController extends AppController {
    private $petsitterRepository;

    public function __construct() {
        parent::__construct();
        $this->petsitterRepository = new PetsitterRepository();
    }

    public function search() {
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        $serviceType = $_GET['service_type'] ?? null;
        $petTypes = $_GET['pet_types'] ?? [];

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 15;

        $petsitters = $this->petsitterRepository->searchPetsitters($startDate, $endDate, $serviceType, $petTypes, $page, $perPage);
        $totalPetsitters = $this->petsitterRepository->countSearchResults($startDate, $endDate, $serviceType, $petTypes);

        $this->render('findAPetsitter', [
            'petsitters' => $petsitters,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'serviceType' => $serviceType,
            'petTypes' => $petTypes,
            'currentPage' => $page,
            'totalPages' => ceil($totalPetsitters / $perPage)
        ]);
    }
    
}
