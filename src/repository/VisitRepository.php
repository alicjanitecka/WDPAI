<?php
require_once 'Repository.php';
require_once __DIR__.'/../models/Visit.php';
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
    

    public function getVisitsByUserId(int $userId): array {
        $stmt = $this->database->connect()->prepare("
        SELECT v.*, 
       u.first_name as petsitter_first_name,
       u.last_name as petsitter_last_name,
       u.phone as petsitter_phone,
        CONCAT(u.street, ' ', u.house_number, 
                CASE WHEN u.apartment_number IS NOT NULL 
                    THEN CONCAT('/', u.apartment_number) 
                    ELSE '' 
                END,
                ', ', u.postal_code, ' ', u.city) as petsitter_address,
        array_agg(p.name) as pet_names
    FROM public.visit v
    JOIN public.petsitter ps ON v.petsitter_id = ps.id
    JOIN public.user u ON ps.user_id = u.id
    JOIN public.pet p ON p.id = ANY(v.pets)
    WHERE v.user_id = :userId
    GROUP BY v.id, u.first_name, u.last_name, u.phone, 
            u.street, u.house_number, u.apartment_number, u.postal_code, u.city
    ORDER BY v.start_date DESC

        ");
        
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $visits = [];
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $visit) {
            $visits[] = new Visit($visit);
        }
        return $visits;
    }
    

    public function getVisitsByPetsitterId(int $petsitterId): array
{
    $stmt = $this->database->connect()->prepare('
        SELECT v.*, 
               u.first_name as owner_first_name, 
               u.last_name as owner_last_name,
               u.phone as owner_phone,
               CONCAT(u.street, \' \', u.house_number, 
                     CASE WHEN u.apartment_number IS NOT NULL 
                          THEN CONCAT(\'/\', u.apartment_number) 
                          ELSE \'\' 
                     END,
                     \', \', u.postal_code, \' \', u.city) as owner_address,
               array_agg(p.name) as pet_names
        FROM public.visit v
        JOIN public.user u ON v.user_id = u.id
        JOIN public.pet p ON p.id = ANY(v.pets)
        WHERE v.petsitter_id = :petsitterId
        GROUP BY v.id, u.first_name, u.last_name, u.phone, 
                 u.street, u.house_number, u.apartment_number, u.postal_code, u.city
        ORDER BY v.start_date DESC
    ');
    
    $stmt->bindParam(':petsitterId', $petsitterId, PDO::PARAM_INT);
    $stmt->execute();

    $visits = [];
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        // Convert PostgreSQL array string to PHP array
        if (isset($row['pet_names'])) {
            $row['pet_names'] = explode(',', trim($row['pet_names'], '{}'));
        }
        $visits[] = new Visit($row);
    }

    return $visits;
}


    public function updateVisitStatus(int $visitId, bool $confirmed, bool $canceled): void {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.visit 
            SET confirmed = :confirmed, canceled = :canceled
            WHERE id = :visit_id
        ');
        
        $stmt->bindParam(':visit_id', $visitId, PDO::PARAM_INT);
        $stmt->bindParam(':confirmed', $confirmed, PDO::PARAM_BOOL);
        $stmt->bindParam(':canceled', $canceled, PDO::PARAM_BOOL);
        $stmt->execute();
    }
    
}
