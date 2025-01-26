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
            $user['name'],
            $user['surname'],
            $user['avatar_url']
        );
    }

    public function addUser(User $user): bool {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.user (email, password, name, surname)
            VALUES (:email, :password, :name, :surname)
        ');

        return $stmt->execute([
            ':email' => $user->getEmail(),
            ':password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
            ':name' => $user->getName(),
            ':surname' => $user->getSurname()
        ]);
    }
    public function updateUser($userId, $userData) {
        error_log('Updating user in repository');
        error_log('User data: ' . print_r($userData, true));
        $stmt = $this->database->connect()->prepare('
            UPDATE public.user 
            SET first_name = ?, last_name = ?, phone = ?, 
                city = ?, street = ?, house_number = ?, 
                apartment_number = ?, avatar_url = ?
            WHERE id = ?
        ');
        
        $stmt->execute([
            $userData['first_name'],
            $userData['last_name'],
            $userData['phone'],
            $userData['city'],
            $userData['street'],
            $userData['house_number'],
            $userData['apartment_number'],
            $userData['avatar_url'],
            $userId
        ]);
    }
}
