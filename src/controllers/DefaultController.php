<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/PetsitterRepository.php';
require_once __DIR__ . '/../repository/PetRepository.php';
class DefaultController extends AppController{
    private $petsitterRepository;
    private $userRepository;
    private $petRepository;
    private $userPet;

    public function __construct() {
        parent::__construct();
        $this->petsitterRepository = new PetsitterRepository();
        $this->userRepository = new UserRepository();
        $this->petRepository = new PetRepository();

    }

    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login');
        }
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login');
        }

        $userId = $_SESSION['user_id'];
        $userPets = $this->petRepository->getPetsByUserId($userId);
        $user = $this->userRepository->getUserById($userId);
        $isPetsitter = $this->petsitterRepository->isPetsitter($userId);


        return $this->render('dashboard', [
            'user' => $user,
            'isPetsitter' => $isPetsitter,
            'userPets' => $userPets
        ]);
    }
    
    public function signup() {
        $this->render('signup');
    }

    

}