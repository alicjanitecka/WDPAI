<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        $this->render('login');
    }

    public function projects(){
        $this->render('dashboard');
    }

    public function book(){
        $this->render('findAPetsitter');
    }
    public function signup() {
        $this->render('signup');
    }
}