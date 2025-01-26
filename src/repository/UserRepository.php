<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $email): ?User {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.user WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['phone'],
        $user['city'],
        $user['street'],
        $user['house_number'],
        $user['apartment_number'],
            $user['avatar_url']
        );
    }

    public function addUser(User $user): bool {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.user (email, password, first_name, last_name)
            VALUES (:email, :password, :first_name, :last_name)
        ');

        return $stmt->execute([
            ':email' => $user->getEmail(),
            ':password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName()
        ]);
    }
public function updateUser($userId, $userData) {
    try {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.user 
            SET first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                city = :city,
                street = :street,
                house_number = :house_number,
                apartment_number = :apartment_number
            WHERE id = :id
        ');

        return $stmt->execute([
            ':first_name' => $userData['first_name'],
            ':last_name' => $userData['last_name'],
            ':phone' => $userData['phone'],
            ':city' => $userData['city'],
            ':street' => $userData['street'],
            ':house_number' => $userData['house_number'],
            ':apartment_number' => $userData['apartment_number'],
            ':id' => $userId
        ]);
        if (!$result) {
            // error_log("Update failed for user: " . $userId);
            throw new Exception('Update query failed');
        }
        return true;
    } catch (PDOException $e) {
        throw new Exception('Database error: ' . $e->getMessage());
    }
}
public function getUserById($id) {
    try {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.user WHERE id = :id
        ');
        $stmt->execute([':id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return null;
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['phone'],
            $user['city'],
            $user['street'],
            $user['house_number'],
            $user['apartment_number'],
            $user['avatar_url']
        );
    } catch (PDOException $e) {
        return null;
    }
}

}