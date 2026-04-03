<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Reservation;
use Exception;
use PDO;
use PDOException;

class ReservationRepository extends Repository
{
    public function createReservation(Reservation $reservation)
    {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO reservations 
                (name, reservation_date, total_adult, total_children, email, phone, user_id, session_id, restaurant_id, remarks, total_cost, payment_status, confirmation_code) 
                VALUES 
                (:name, :reservation_date, :total_adult, :total_children, :email, :phone, :user_id, :session_id, :restaurant_id, :remarks, :total_cost, :payment_status, :confirmation_code)"
            );
            $stmt->execute([
                ':name' => $reservation->getName(),
                ':reservation_date' => $reservation->getReservationDate(),
                ':total_adult' => $reservation->getTotalAdult(),
                ':total_children' => $reservation->getTotalChildren(),
                ':email' => $reservation->getEmail(),
                ':phone' => $reservation->getPhone(),
                ':user_id' => $reservation->getUserId(),
                ':session_id' => $reservation->getSessionId(),
                ':restaurant_id' => $reservation->getRestaurantId(),
                ':remarks' => $reservation->getRemarks(),
                ':total_cost' => $reservation->getCost(),
                ':payment_status' => $reservation->getPaymentStatus(),
                ':confirmation_code' => $reservation->getConfirmationCode(),
            ]);
            $reservationId = $this->connection->lastInsertId();
            return $reservationId;
        } catch (PDOException $e) {
            throw new Exception("Error creating reservation: " . $e->getMessage());
        }
    }

    public function updateReservationStatus($reservation_id, $status)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE reservations SET is_active = :status WHERE reservation_id = :reservation_id");
            $stmt->execute([
                ':status' => $status,
                ':reservation_id' => $reservation_id
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating reservation status: " . $e->getMessage());
        }
    }

    public function updateReservation(Reservation $reservation)
    {
        try {
            $stmt = $this->connection->prepare(
                "UPDATE reservations SET 
            name = :name, 
            reservation_date = :reservation_date, 
            total_adult = :total_adult, 
            total_children = :total_children, 
            email = :email, 
            phone = :phone, 
            session_id = :session_id, 
            restaurant_id = :restaurant_id, 
            remarks = :remarks, 
            total_cost = :total_cost 
            WHERE reservation_id = :reservation_id"
            );
            $stmt->execute([
                ':name' => $reservation->getName(),
                ':reservation_date' => $reservation->getReservationDate(),
                ':total_adult' => $reservation->getTotalAdult(),
                ':total_children' => $reservation->getTotalChildren(),
                ':email' => $reservation->getEmail(),
                ':phone' => $reservation->getPhone(),
                ':session_id' => $reservation->getSessionId(),
                ':restaurant_id' => $reservation->getRestaurantId(),
                ':remarks' => $reservation->getRemarks(),
                ':total_cost' => $reservation->getCost(),
                ':reservation_id' => $reservation->getReservationId()
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating reservation: " . $e->getMessage());
        }
    }

    public function getAllReservations()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM reservations");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all reservations: " . $e->getMessage());
        }
    }

    public function getReservationById($reservation_id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE reservation_id = :reservation_id");
            $stmt->bindParam(':reservation_id', $reservation_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching reservation by ID: " . $e->getMessage());
        }
    }

    public function getReservationsByRestaurantId($restaurant_id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE restaurant_id = :restaurant_id");
            $stmt->bindParam(':restaurant_id', $restaurant_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching reservations by restaurant ID: " . $e->getMessage());
        }
    }

    public function getReservationsByUserId($user_id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching reservations by user ID: " . $e->getMessage());
        }
    }
}
