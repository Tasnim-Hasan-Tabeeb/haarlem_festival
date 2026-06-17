<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Repository;
use Exception;
use PDO;
use PDOException;

class UserRepository extends Repository
{
    public function getAllUsers()
    {
        $stmt = $this->connection->prepare('SELECT * FROM users');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function createUser($user)
    {
        $user = new User();
        $user->setuserid($user['userid']);
        $user->setname($user['name']);
        $user->setemail($user['email']);
        $user->setpassword($user['password']);
        $user->setrole($user['role']);
        $user->setprofilepicture($user['profile_picture']);
        $user->setregistration_date($user['registration_date']);
        return $user;
    }

    /**
     * Summary of authenticateUser
     * @param mixed $email
     * @param mixed $password
     * @throws Exception
     */
    public function authenticateUser($email, $password)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $userRow['password'])) {
                return $userRow;
            }
        }
        return null;
    }

    /**
     * Summary of registerUser
     * @param mixed $newUser
     * @throws Exception
     * @return bool
     */
    public function registerUser($newUser): bool
    {
        $sql = 'INSERT INTO users (name, email, password, role, profile_picture) 
            VALUES (:name, :email, :password, :role, :profile_picture)';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':name', $newUser['name']);
        $stmt->bindValue(':email', $newUser['email']);
        $stmt->bindValue(':password', $newUser['password']);
        $stmt->bindValue(':role', Role::getLabel($newUser['role']));
        $stmt->bindValue(':profile_picture', $newUser['profile_picture']);
        $stmt->execute();
        return true;
    }

    /**
     * Summary of checkUserExistence
     * @param mixed $stmt
     * @return bool
     */
    private function checkUserExistence($stmt): bool
    {
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Summary of checkUserExistenceByEmail
     * @param mixed $email
     */
    public function checkUserExistenceByEmail($email)
    {
        $stmt = $this->connection->prepare('SELECT user_id From users WHERE email= :email');
        $stmt->bindValue(':email', $email);
        if ($this->checkUserExistence($stmt)) {
            $stmt->execute();
            $result = $stmt->fetch();
            return $result[0];
        }
    }

    public function storeUser(User $user)
    {
        $stmt = $this->connection->prepare('INSERT INTO users (name, email, password, role, profile_picture) VALUES (:name, :email, :password, :role, :profile_picture)');
        $stmt->execute([
            ':name'            => $user->getname(),
            ':email'           => $user->getemail(),
            ':password'        => $user->getpassword(),
            ':role'            => $user->getrole(),
            ':profile_picture' => $user->getprofilepicture(),
        ]);
        return true;
    }

    /**
     * Summary of getUserById
     * @param mixed $userId
     * @throws Exception
     */
    public function getUserById($userId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE user_id = :userid');
        $stmt->bindParam(':userid', $userId);
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $userRow;
        }
        return null;
    }

    /**
     * Summary of updateUser
     * @param mixed $user
     * @throws Exception
     * @return bool
     */
    public function updateUser($user)
    {
        $stmt = $this->connection->prepare('UPDATE users SET name = :name, email = :email, role = :role, profile_picture = :profile_picture WHERE user_id = :userid');
        $stmt->execute([
            ':userid'          => $user['user_id'],
            ':name'            => $user['name'],
            ':email'           => $user['email'],
            ':role'            => $user['role'],
            ':profile_picture' => $user['profile_picture'],
        ]);
        return true;
    }

    /**
     * Summary of deleteUser
     * @param mixed $userId
     * @throws Exception
     * @return bool
     */
    public function deleteUser($userId)
    {
        $stmt = $this->connection->prepare('DELETE FROM users WHERE user_id = :userid');
        $stmt->bindParam(':userid', $userId);
        $stmt->execute();
        return true;
    }

    /**
     * Summary of getUserByEmail
     * @param mixed $email
     * @throws Exception
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userRow !== false) {
            return $userRow; // Return the user details array
        }

        return null;
    }

    /**
     * Summary of resetPassword
     * @param mixed $email
     * @param mixed $password
     * @throws Exception
     * @return bool
     */
    public function resetPassword($email, $password)
    {
        $stmt = $this->connection->prepare('UPDATE users SET password = :password WHERE email = :email');
        $stmt->execute([
            ':email'    => $email,
            ':password' => $password,
        ]);
        unset($_SESSION['password_reset_token']);
        unset($_SESSION['email']);

        return true;
    }

    /**
     * Summary of updateProfile
     * @param mixed $user
     * @throws Exception
     * @return bool
     */
    public function updateProfile($user)
    {
        $stmt = $this->connection->prepare('UPDATE users SET name = :name, profile_picture = :profile_picture WHERE user_id = :userid');
        $stmt->execute([
            ':userid'          => $user['user_id'],
            ':name'            => $user['name'],
            ':profile_picture' => $user['profile_picture'],
        ]);
        return true;
    }

    /**
     * Summary of updatePassword
     * @param mixed $userId
     * @param mixed $password
     * @throws Exception
     * @return bool
     */
    public function updatePassword($userId, $password)
    {
        $stmt = $this->connection->prepare('UPDATE users SET password = :password WHERE user_id = :userid');
        $stmt->execute([
            ':userid'   => $userId,
            ':password' => $password,
        ]);
        return true;
    }
}
