<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Repository;
use App\Models\User;
use Exception;
use PDO;
use PDOException;

class UserRepository extends Repository
{
    private $db;

    public function getAllUsers()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function createUser($user)
    {
        try {
            $user = new User();
            $user->setuserid($user['userid']);
            $user->setname($user['name']);
            $user->setemail($user['email']);
            $user->setpassword($user['password']);
            $user->setrole($user['role']);
            $user->setprofilepicture($user['profile_picture']);
            $user->setregistration_date($user['registration_date']);
            return $user;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function authenticateUser($email, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                if (password_verify($password, $userRow['password'])) {
                    return $userRow;
                }
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function registerUser($newUser): bool
    {
        try {
            $sql = "INSERT INTO users (name, email, password, role, profile_picture) 
                VALUES (:name, :email, :password, :role, :profile_picture)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':name', $newUser['name']);
            $stmt->bindValue(':email', $newUser['email']);
            $stmt->bindValue(':password', $newUser['password']);
            $stmt->bindValue(':role', Role::getLabel($newUser['role']));
            $stmt->bindValue(':profile_picture', $newUser['profile_picture']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    private function checkUserExistence($stmt): bool
    {
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo $e;
            exit();
        }
    }

    public function checkUserExistenceByEmail($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT user_id From users WHERE email= :email");
            $stmt->bindValue(':email', $email);
            if ($this->checkUserExistence($stmt)) {
                $stmt->execute();
                $result = $stmt->fetch();
                return $result[0];
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function storeUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO users (name, email, password, role, profile_picture) VALUES (:name, :email, :password, :role, :profile_picture)");
            $stmt->execute([
                ':name' => $user->getname(),
                ':email' => $user->getemail(),
                ':password' => $user->getpassword(),
                ':role' => $user->getrole(),
                ':profile_picture' => $user->getprofilepicture(),
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getUserById($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE user_id = :userid");
            $stmt->bindParam(':userid', $userId);
            $stmt->execute();
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return $userRow;
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateUser($user)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET name = :name, email = :email, role = :role, profile_picture = :profile_picture WHERE user_id = :userid");
            $stmt->execute([
                ':userid' => $user['user_id'],
                ':name' => $user['name'],
                ':email' => $user['email'],
                ':role' => $user['role'],
                ':profile_picture' => $user['profile_picture'],
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteUser($userId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM users WHERE user_id = :userid");
            $stmt->bindParam(':userid', $userId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userRow !== false) {
                return $userRow; // Return the user details array
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }



    public function resetPassword($email, $password)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->execute([
                ':email' => $email,
                ':password' => $password,
            ]);
            unset($_SESSION['password_reset_token']);
            unset($_SESSION['email']);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

}
