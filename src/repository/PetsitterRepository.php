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
    public function getPetsitterServices($userId) {
        $stmt = $this->database->connect()->prepare('
            SELECT is_dog_sitter, is_cat_sitter, is_rodent_sitter, care_at_owner_home, care_at_petsitter_home, dog_walking, hourly_rate
        FROM public.petsitter
        WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return [
                'pet_types' => [
                    'dog' => $result['is_dog_sitter'],
                    'cat' => $result['is_cat_sitter'],
                    'rodent' => $result['is_rodent_sitter']
                ],
                'services' => [
                    'care_at_owner_home' => $result['care_at_owner_home'],
                    'care_at_petsitter_home' => $result['care_at_petsitter_home'],
                    'dog_walking' => $result['dog_walking']
                ],
                'hourly_rate' => $result['hourly_rate']
            ];
        }
        
        return null;
    }
    public function updatePetsitter($userId, $data) {
        try {
            $stmt = $this->database->connect()->prepare('
                UPDATE public.petsitter 
                SET description = :description
                WHERE user_id = :user_id
            ');
            
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating petsitter: " . $e->getMessage());
            return false;
        }
    }
    public function getPetsitterByUserId($userId) {
        try {
            $stmt = $this->database->connect()->prepare('
                SELECT * FROM public.petsitter WHERE user_id = :user_id
            ');
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            $petsitterData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($petsitterData) {
                return new Petsitter(
                    $petsitterData['id'],
                    $petsitterData['user_id'],
                    $petsitterData['description']
                );
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Error getting petsitter by user ID: " . $e->getMessage());
            return null;
        }
    }
    public function updatePetsitterServices($userId, $data) {
        try {
            $stmt = $this->database->connect()->prepare('
                UPDATE public.petsitter 
                SET is_dog_sitter = :is_dog_sitter,
                    is_cat_sitter = :is_cat_sitter,
                    is_rodent_sitter = :is_rodent_sitter,
                    care_at_owner_home = :care_at_owner_home,
                    care_at_petsitter_home = :care_at_petsitter_home,
                    dog_walking = :dog_walking,
                    hourly_rate = :hourly_rate
                WHERE user_id = :user_id
            ');
            
            $stmt->bindParam(':is_dog_sitter', $data['is_dog_sitter'], PDO::PARAM_BOOL);
            $stmt->bindParam(':is_cat_sitter', $data['is_cat_sitter'], PDO::PARAM_BOOL);
            $stmt->bindParam(':is_rodent_sitter', $data['is_rodent_sitter'], PDO::PARAM_BOOL);
            $stmt->bindParam(':care_at_owner_home', $data['care_at_owner_home'], PDO::PARAM_BOOL);
            $stmt->bindParam(':care_at_petsitter_home', $data['care_at_petsitter_home'], PDO::PARAM_BOOL);
            $stmt->bindParam(':dog_walking', $data['dog_walking'], PDO::PARAM_BOOL);
            $stmt->bindParam(':hourly_rate', $data['hourly_rate'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating petsitter services: " . $e->getMessage());
            return false;
        }
    }
    
    
}
