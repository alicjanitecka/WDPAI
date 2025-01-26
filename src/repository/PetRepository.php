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
            
            $params = [
                $pet->getUserId(),
                $pet->getName(),
                $pet->getAge(),
                $pet->getSpecies(),
                $pet->getBreed(),
                $pet->getAdditionalInfo(),
                $pet->getPhotoUrl()
            ];
            
            error_log("Executing SQL with params: " . print_r($params, true));
            
            $result = $stmt->execute($params);
            
            error_log("SQL execution result: " . ($result ? "success" : "failure"));
            
            return $result;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw $e;
        }
    }
    

    public function getPetsByUserId($userId) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.pet WHERE user_id = ? ORDER BY name
        ');
        $stmt->execute([$userId]);
    
        $pets = [];
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($result as $pet) {
            $pets[] = new Pet(
                $pet['user_id'],
                $pet['name'],
                $pet['age'],
                $pet['species'],
                $pet['breed'],
                $pet['additional_info'],
                $pet['photo_url']
            );
        }
    
        return $pets;
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
    }

    public function deletePet($id) {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.pet WHERE id = ?
        ');
        
        $stmt->execute([$id]);
    }
    
}
