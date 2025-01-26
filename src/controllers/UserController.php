<?php

class UserController extends AppController {
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function updateUserProfile() {
        if (!$this->isPost()) {
            error_log('Not a POST request in updateUserProfile');
            return $this->render('error', ['message' => 'Wrong request method']);
        }

        if (!isset($_SESSION['user_id'])) {
            error_log('No user_id in session');
            return $this->render('error', ['message' => 'User not logged in']);
        }

        error_log('Updating profile for user: ' . $_SESSION['user_id']);
        error_log('POST data: ' . print_r($_POST, true));

        try {
            $this->userRepository->updateUser($_SESSION['user_id'], $_POST);
            error_log('Profile updated successfully');
            http_response_code(200);
            return json_encode(['status' => 'success']);
        } catch (Exception $e) {
            error_log('Error updating profile: ' . $e->getMessage());
            http_response_code(500);
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
