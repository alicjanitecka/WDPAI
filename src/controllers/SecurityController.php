<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController {

    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {   
        // $user = new User('jsnow@pk.edu.pl', 'admin', 'Johnny', 'Snow');
        session_start();

        $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
        unset($_SESSION['messages']);

        if (!$this->isPost()) {
            return $this->render('login', ['messages' => $messages]);
        }


        // if (!$this->isPost()) {
        //     return $this->render('login');
        // }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User with this email does not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $_SESSION['user_id'] = $user->getId();
        $petsitterRepository = new PetsitterRepository();
        if ($petsitterRepository->isPetsitter($_SESSION['user_id'])) {
            header("Location: /dashboard");
        } else {
            header("Location: /userDashboard");
        }
        exit();
    }

    public function signup() {
        
        if (!$this->isPost()) {
            return $this->render('signup');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        if ($password !== $confirmedPassword) {
            return $this->render('signup', ['messages' => ['Passwords do not match!']]);
        }

        $user = new User(null, $email, $password, $first_name, $last_name);

        if ($this->userRepository->addUser($user)) {
            $_SESSION['messages'] = ['You\'ve been successfully registered!'];
            // $url = "http://$_SERVER[HTTP_HOST]";
            // header("Location: {$url}/login");
            echo "<script>window.location.href = '/login';</script>";
            exit();
        } else {
            return $this->render('signup', ['messages' => ['Registration failed. Please try again.']]);
        }
    }

    public function logout() {
        if ($this->isPost()) {
            session_start();
            session_unset();
            session_destroy();
            echo "<script>window.location.href = '/dashboard';</script>";
            exit();
        }
    }
    
    
}