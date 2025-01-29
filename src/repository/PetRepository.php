<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Pet.php';
class PetRepository extends Repository {
    public function addPet(Pet $pet) {
        try {
            $conn = $this->database->connect();
            
            $stmt = $conn->prepare('
                INSERT INTO public.pet (user_id, name, age, species, breed, additional_info, photo_url)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ');
            
            return $stmt->execute([
                $pet->getUserId(),
                $pet->getName(),
                $pet->getAge(),
                $pet->getSpecies(),
                $pet->getBreed(),
                $pet->getAdditionalInfo(),
                $pet->getPhotoUrl()
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
    

    public function getPetsByUserId($userId) {
        try {
            $stmt = $this->database->connect()->prepare('
                SELECT * FROM public.pet WHERE user_id = :userId
            ');
            
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            
            foreach ($pets as $pet) {
                $result[] = new Pet(
                    $pet['id'],
                    $pet['user_id'],
                    $pet['name'],
                    $pet['age'],
                    $pet['species'],
                    $pet['breed'],
                    $pet['additional_info'],
                    $pet['photo_url']
                );
            }
            
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }
    

    public function updatePet(Pet $pet) {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.pet 
            SET name = ?, age = ?, species = ?, breed = ?, additional_info = ?, photo_url = ?
            WHERE id = ?
        ');
        
        $stmt->execute([
            $pet->getName(),
            $pet->getAge(),
            $pet->getSpecies(),
            $pet->getBreed(),
            $pet->getAdditionalInfo(),
            $pet->getPhotoUrl(),
            $pet->getId()
        ]);
        return true;
    }

    public function deletePetById($petId) {
        try {
            $conn = $this->database->connect();
            $stmt = $conn->prepare('DELETE FROM public.pet WHERE id = :id');
            $stmt->bindParam(':id', $petId, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            // if ($result && $stmt->rowCount() > 0) {
            //     return true;
            // }
            return $result && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Database error while deleting pet: ' . $e->getMessage());
            return false;
        }
    }
    
    
    
    
}
