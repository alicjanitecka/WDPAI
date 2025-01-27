<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Petsitter.php';

class PetsitterRepository extends Repository {
    public function createPetsitter($userId, $description) {
        try {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO public.petsitter (user_id, description)
                VALUES (?, ?)
            ');
            return $stmt->execute([$userId, $description]);
        } catch (PDOException $e) {
            error_log("Error creating petsitter: " . $e->getMessage());
            return false;
        }
    }
    
    public function addAvailability($petsitterId, $date) {
        try {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO public.petsitter_availability (petsitter_id, date)
                VALUES (?, ?)
            ');
            return $stmt->execute([$petsitterId, $date]);
        } catch (PDOException $e) {
            error_log("Error adding availability: " . $e->getMessage());
            return false;
        }
    }
    public function getPetsitterId($userId) {
        try {
            $stmt = $this->database->connect()->prepare('
                SELECT id FROM public.petsitter WHERE user_id = :user_id
            ');
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['id'];
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Error getting petsitter ID: " . $e->getMessage());
            return null;
        }
    }
    public function isPetsitter($userId) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.petsitter WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->rowCount() > 0;
    error_log("User $userId is petsitter: " . ($result ? 'true' : 'false'));
    return $result;
    }
    
}
