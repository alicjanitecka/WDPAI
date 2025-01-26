<?php

class Pet {
    private $id;
    private $userId;
    private $name;
    private $age;
    private $species;
    private $breed;
    private $additionalInfo;
    private $photoUrl;

    // konstruktor
    public function __construct($userId, $name, $age, $species, $breed, $additionalInfo, $photoUrl = null) {
        $this->userId = $userId;
        $this->name = $name;
        $this->age = $age;
        $this->species = $species;
        $this->breed = $breed;
        $this->additionalInfo = $additionalInfo;
        $this->photoUrl = $photoUrl;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getAge(): ?int {
        return $this->age;
    }

    public function setAge(?int $age) {
        $this->age = $age;
    }

    public function getSpecies(): ?string {
        return $this->species;
    }

    public function setSpecies(?string $species) {
        $this->species = $species;
    }

    public function getBreed(): ?string {
        return $this->breed;
    }

    public function setBreed(?string $breed) {
        $this->breed = $breed;
    }

    public function getAdditionalInfo(): ?string {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo) {
        $this->additionalInfo = $additionalInfo;
    }

    public function getPhotoUrl(): ?string {
        return $this->photoUrl;
    }

    public function setPhotoUrl(?string $photoUrl) {
        $this->photoUrl = $photoUrl;
    }
}
