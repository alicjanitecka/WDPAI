<?php
require_once 'Repository.php';

class VisitRepository extends Repository
{
    public function createVisit(array $visitData): void
    {
        try {
            error_log('Creating visit with data: ' . print_r($visitData, true));
            
            $stmt = $this->database->connect()->prepare('
                INSERT INTO public.visit 
                (user_id, petsitter_id, care_type, start_date, end_date, pets)
                VALUES (?, ?, ?, ?, ?, ?)
            ');
    
            $petsArray = '{' . implode(',', $visitData['pets']) . '}';
            error_log('Prepared pets array: ' . $petsArray);
    
            $stmt->execute([
                $visitData['user_id'],
                $visitData['petsitter_id'],
                $visitData['care_type'],
                $visitData['start_date'],
                $visitData['end_date'],
                $petsArray
            ]);
    
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Error creating visit: ' . $e->getMessage());
        }
    }
    

    public function getVisitsByUserId(int $userId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT v.*, p.first_name as petsitter_name
            FROM public.visit v
            JOIN public.petsitter p ON v.petsitter_id = p.id
            WHERE v.user_id = :userId
        ');
        
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVisitsByPetsitterId(int $petsitterId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT v.*, u.first_name as owner_name
            FROM public.visit v
            JOIN public.users u ON v.user_id = u.id
            WHERE v.petsitter_id = :petsitterId
        ');
        
        $stmt->bindParam(':petsitterId', $petsitterId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
