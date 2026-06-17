<?php

namespace App\Repositories;

use App\Models\Reservation;
use Exception;
use PDO;
use PDOException;

class ReservationRepository extends Repository
{
    public function createReservation(Reservation $reservation)
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO reservations 
            (name, reservation_date, total_adult, total_children, email, phone, user_id, session_id, restaurant_id, remarks, total_cost, payment_status, confirmation_code) 
            VALUES 
            (:name, :reservation_date, :total_adult, :total_children, :email, :phone, :user_id, :session_id, :restaurant_id, :remarks, :total_cost, :payment_status, :confirmation_code)'
        );
        $stmt->execute([
            ':name'              => $reservation->getName(),
            ':reservation_date'  => $reservation->getReservationDate(),
            ':total_adult'       => $reservation->getTotalAdult(),
            ':total_children'    => $reservation->getTotalChildren(),
            ':email'             => $reservation->getEmail(),
            ':phone'             => $reservation->getPhone(),
            ':user_id'           => $reservation->getUserId(),
            ':session_id'        => $reservation->getSessionId(),
            ':restaurant_id'     => $reservation->getRestaurantId(),
            ':remarks'           => $reservation->getRemarks(),
            ':total_cost'        => $reservation->getCost(),
            ':payment_status'    => $reservation->getPaymentStatus(),
            ':confirmation_code' => $reservation->getConfirmationCode(),
        ]);
        $reservationId = $this->connection->lastInsertId();
        return $reservationId;
    }

    /**
     * Summary of updateReservationStatus
     * @param mixed $reservation_id
     * @param mixed $status
     * @throws Exception
     * @return bool
     */
    public function updateReservationStatus($reservation_id, $status)
    {
        $stmt = $this->connection->prepare('UPDATE reservations SET is_active = :status WHERE reservation_id = :reservation_id');
        $stmt->execute([
            ':status'         => $status,
            ':reservation_id' => $reservation_id
        ]);
        return true;
    }

    public function updateReservation(Reservation $reservation)
    {
        $stmt = $this->connection->prepare(
            'UPDATE reservations SET 
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
        WHERE reservation_id = :reservation_id'
        );
        $stmt->execute([
            ':name'             => $reservation->getName(),
            ':reservation_date' => $reservation->getReservationDate(),
            ':total_adult'      => $reservation->getTotalAdult(),
            ':total_children'   => $reservation->getTotalChildren(),
            ':email'            => $reservation->getEmail(),
            ':phone'            => $reservation->getPhone(),
            ':session_id'       => $reservation->getSessionId(),
            ':restaurant_id'    => $reservation->getRestaurantId(),
            ':remarks'          => $reservation->getRemarks(),
            ':total_cost'       => $reservation->getCost(),
            ':reservation_id'   => $reservation->getReservationId()
        ]);
        return true;
    }

    public function getAllReservations()
    {
        $stmt = $this->connection->prepare('SELECT * FROM reservations');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getReservationById
     * @param mixed $reservation_id
     * @throws Exception
     */
    public function getReservationById($reservation_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM reservations WHERE reservation_id = :reservation_id');
        $stmt->bindParam(':reservation_id', $reservation_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getReservationsByRestaurantId
     * @param mixed $restaurant_id
     * @throws Exception
     * @return array
     */
    public function getReservationsByRestaurantId($restaurant_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM reservations WHERE restaurant_id = :restaurant_id');
        $stmt->bindParam(':restaurant_id', $restaurant_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getReservationsByUserId
     * @param mixed $user_id
     * @throws Exception
     * @return array
     */
    public function getReservationsByUserId($user_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM reservations WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of deleteReservation
     * @param mixed $reservation_id
     * @return bool
     */
    public function deleteReservation($reservation_id)
    {
        $stmt = $this->connection->prepare('DELETE FROM reservations WHERE reservation_id = :reservation_id');
        $stmt->bindParam(':reservation_id', $reservation_id);
        $stmt->execute();
        return true;
    }
}
