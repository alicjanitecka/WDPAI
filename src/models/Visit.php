<?php
class Visit {
    private $id;
    private $user_id;
    private $petsitter_id;
    private $careType;

    private $startDate;
    private $endDate;
    private $pets;
    private $confirmed;
    private $canceled;
    private $ownerFirstName;
    private $ownerLastName;
    private $ownerPhone;
    private $ownerAddress;
    private $petNames;
    
    private $petsitterFirstName;
    
    private $petsitterLastName;
    
    private $petsitterPhone;
    
    private $petsitterAddress;

    public function __construct(array $visitData) {
        $this->id = $visitData['id'];
        $this->user_id = $visitData['user_id'];
        $this->petsitter_id = $visitData['petsitter_id'];
        $this->careType = $visitData['care_type'];
        $this->startDate = $visitData['start_date'];
        $this->endDate = $visitData['end_date'];
        $this->pets = $visitData['pets'];
        $this->confirmed = $visitData['confirmed'] ?? false; 
        $this->canceled = $visitData['canceled'] ?? false;
        $this->ownerFirstName = $visitData['owner_first_name'] ?? '';
        $this->ownerLastName = $visitData['owner_last_name'] ?? '';
        $this->ownerPhone = $visitData['owner_phone'] ?? '';
        $this->ownerAddress = $visitData['owner_address'] ?? '';
        $this->petNames = $visitData['pet_names'] ?? [];
        $this->petsitterFirstName = $visitData['petsitter_first_name'] ?? '';
        $this->petsitterLastName = $visitData['petsitter_last_name'] ?? '';
        $this->petsitterPhone = $visitData['petsitter_phone'] ?? '';
        $this->petsitterAddress = $visitData['petsitter_address'] ?? '';
    }

    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function getPetsitterId() {
        return $this->petsitter_id;
    }
    public function getCareType() {
        return $this->careType;
    }
    public function getStartDate() {
        return $this->startDate;
    }
    public function getEndDate() {
        return $this->endDate;
    }
    public function getPets(): array {
        if (is_string($this->pets)) {
            // Remove the PostgreSQL array brackets {} and split
            $petsString = trim($this->pets, '{}');
            return $petsString ? explode(',', $petsString) : [];
        }
        return is_array($this->pets) ? $this->pets : [];
    }
    public function getIsConfirmed() {
        return (bool)$this->confirmed;
    }
    public function getIsCanceled() {
        return (bool)$this->canceled;
    }
    public function getPetNames(): array {
        if (is_string($this->petNames)) {
            // Jeśli to string (z PostgreSQL), konwertujemy go na tablicę
            return explode(',', trim($this->petNames, '{}'));
        }
        return is_array($this->petNames) ? $this->petNames : [];
    }
    public function getOwnerFirstName() {
        return $this->ownerFirstName;
    }
    public function getOwnerLastName() {
        return $this->ownerLastName;
    }
    public function getOwnerPhone()  {
        return $this->ownerPhone;
    }
    public function getOwnerAddress() {
        return $this->ownerAddress;
    }
    public function getPetsitterFirstName() {
        return $this->petsitterFirstName;
    }
    public function getPetsitterLastName() {
        return $this->petsitterLastName;
    }
    
    public function getPetsitterPhone(): ?string {
        return $this->petsitterPhone;
    }
    
    public function getPetsitterAddress(): string {
        return $this->petsitterAddress;
    }
    
}
