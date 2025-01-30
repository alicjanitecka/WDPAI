<?php

class Pet {
    private $id;
    private $userId;
    private $name;
    private $age;
    private $petType;
    private $breed;
    private $additionalInfo;
    private $photoUrl;

    // konstruktor
    public function __construct($id, $userId, $name, $age, $petType, $breed, $additionalInfo, $photoUrl = null) {
        
        $this->id=$id;
        $this->userId = $userId;
        $this->name = $name;
        $this->age = $age;
        $this->petType = $petType;
        $this->breed = $breed;
        $this->additionalInfo = $additionalInfo;
        $this->photoUrl = $photoUrl;
    }

    public function getId(): ?int {
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
    public function getPetType(): string {
        return $this->petType ?? 'Unknown';
    }
    


    public function setPetType(string $petType): void {
        if (!in_array($petType, ['dog', 'cat', 'rodent'])) {
            throw new InvalidArgumentException('Invalid pet type');
        }
        $this->petType = $petType;
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
