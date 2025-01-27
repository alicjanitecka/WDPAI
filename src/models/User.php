<?php

class User{
    private $id;
    private $email;
    private $password;
    private $first_name;
    private $last_name;
    private $phone;
    private $city;
    private $postal_code;
    private $street;
    private $houseNumber;
    private $apartmentNumber;
    private $avatarUrl;

    public function __construct(
        $id, $email, $password, $first_name, $last_name, $phone=null, $city=null, $postal_code=null,
        $street=null,
        $houseNumber=null,
        $apartmentNumber=null, $avatarUrl = null
    ) {
        $this->id= $id;
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->city = $city;
        $this->postal_code=$postal_code;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->apartmentNumber = $apartmentNumber;
        $this->avatarUrl = $avatarUrl;
    }
    public function getId() {
        return $this->id;
    }
    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getAvatarUrl() {
        return $this->avatarUrl;
    }
    public function getPhone() {
        return $this->phone;
    }

    public function getCity() {
        return $this->city;
    }
    public function getPostalCode() {
        return $this->street;
    }
    public function getStreet() {
        return $this->street;
    }

    public function getHouseNumber() {
        return $this->houseNumber;
    }

    public function getApartmentNumber() {
        return $this->apartmentNumber;
    }
}