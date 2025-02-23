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
            return $result ? $result['id'] : null;
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
                    'dog' => (bool)$result['is_dog_sitter'],
                    'cat' => (bool)$result['is_cat_sitter'],
                    'rodent' => (bool)$result['is_rodent_sitter']
                ],
                'services' => [
                    'care_at_owner_home' => (bool)$result['care_at_owner_home'],
                    'care_at_petsitter_home' => (bool)$result['care_at_petsitter_home'],
                    'dog_walking' => (bool)$result['dog_walking']
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
    
    
    public function countSearchResults($startDate, $endDate, $serviceType, $petIds) {
        $query = "SELECT COUNT(*) FROM public.petsitter p
                  JOIN public.petsitter_availability pa ON p.id = pa.petsitter_id
                  WHERE pa.date BETWEEN :start_date AND :end_date 
                  AND pa.is_available = true";
        
        if ($serviceType) {
            $query .= " AND p.$serviceType = true";
        }
        
        if (!empty($petIds)) {
            $petTypes = $this->getPetTypes($petIds);
            foreach ($petTypes as $type) {
                $query .= " AND p.is_{$type}_sitter = true";
            }
        }
        
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindValue(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindValue(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    
    private function getPetTypes($petIds) {
        $stmt = $this->database->connect()->prepare("SELECT DISTINCT pet_type FROM public.pet WHERE id IN (" . implode(',', array_fill(0, count($petIds), '?')) . ")");
        $stmt->execute($petIds);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public static function getServicesOffered($petsitter) {
        $services = [];
        if ($petsitter['care_at_owner_home']) $services[] = 'care at owner\'s home';
        if ($petsitter['care_at_petsitter_home']) $services[] = 'care at pet sitter\'s home';
        if ($petsitter['dog_walking']) $services[] = 'walking the dog';
        return implode(', ', $services);
    }

    public static function getServiceLocations($petsitter) {
        $locations = [];
        if ($petsitter['care_at_owner_home']) $locations[] = 'at owner\'s home';
        if ($petsitter['care_at_petsitter_home']) $locations[] = 'at pet sitter\'s home';
        if ($petsitter['dog_walking']) $locations[] = 'outdoors';
        return implode(' / ', $locations);
    }
    
    public function updatePetsitterAvailability($petsitterId, $dates, $isAvailable) {
        try {
            $conn = $this->database->connect();
            $stmt = $conn->prepare('
                INSERT INTO public.petsitter_availability (petsitter_id, date, is_available)
                VALUES (:petsitter_id, :date, :is_available)
                ON CONFLICT (petsitter_id, date) 
                DO UPDATE SET is_available = :is_available
            ');
    
            foreach ($dates as $date) {
                $isAvailableBoolean = $isAvailable ? 'true' : 'false';
                
                if (!$stmt->execute([
                    ':petsitter_id' => $petsitterId,
                    ':date' => $date,
                    ':is_available' => $isAvailableBoolean
                ])) {
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            error_log('Error updating petsitter availability: ' . $e->getMessage());
            return false;
        }
    }
    public function getPetsitterAvailability($petsitterId) {
        try {
            $stmt = $this->database->connect()->prepare('
            SELECT date, is_available 
            FROM public.petsitter_availability 
            WHERE petsitter_id = :petsitter_id 
            AND is_available = true
            ORDER BY date ASC
        ');
            $stmt->bindParam(':petsitter_id', $petsitterId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Fetched availabilities for petsitter ' . $petsitterId . ': ' . print_r($result, true));
            
            return $result;
        } catch (PDOException $e) {
            error_log('Error getting petsitter availability: ' . $e->getMessage());
            return [];
        }
    }
    public function search(array $criteria): array 
    {
        try {

            $careTypeColumn = '';
            switch($criteria['care_type']) {
                case 'petsitter_home':
                    $careTypeColumn = 'care_at_petsitter_home';
                    break;
                case 'owner_home':
                    $careTypeColumn = 'care_at_owner_home';
                    break;
                case 'dog_walking':
                    $careTypeColumn = 'dog_walking';
                    break;
            }

            $query = "SELECT DISTINCT p.id, p.hourly_rate, u.first_name, u.last_name, u.city 
            FROM public.petsitter p
            JOIN public.user u ON p.user_id = u.id
            WHERE p." . $careTypeColumn . " = true
            AND NOT EXISTS (
                SELECT 1 
                FROM public.petsitter_availability pa 
                WHERE pa.petsitter_id = p.id 
                AND pa.date BETWEEN :start_date AND :end_date 
                AND pa.is_available = false
            )
            AND EXISTS (
                SELECT 1 
                FROM public.petsitter_availability pa 
                WHERE pa.petsitter_id = p.id 
                AND pa.date BETWEEN :start_date AND :end_date 
                AND pa.is_available = true
            )";

            $stmt = $this->database->connect()->prepare($query);
            
            $stmt->bindValue(':start_date', $criteria['start_date']);
            $stmt->bindValue(':end_date', $criteria['end_date']);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
}