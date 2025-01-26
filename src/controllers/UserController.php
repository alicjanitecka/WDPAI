<?php
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error.log');
error_log("Request received: " . print_r($_POST, true));


class UserController extends AppController {
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    public function updateUserProfile() {
        session_start();
        if(!$this->isPost() || !isset($_SESSION['user_id'])) {
            return $this->render('error', ['message' => 'Something went wrong']);
        }
    
        $result = $this->userRepository->updateUser($_SESSION['user_id'], $_POST);
        
        if ($result) {
            header('Location: /account');
        } else {
            return $this->render('error', ['message' => 'Update failed']);
        }
    }    
}
