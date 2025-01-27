<?php

class Petsitter {
    private $id;
    private $userId;
    private $address;
    private $phone;

    public function __construct($id, $userId, $address, $phone) {
        $this->id = $id;
        $this->userId = $userId;
        $this->address = $address;
        $this->phone = $phone;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPhone() {
        return $this->phone;
    }
}
