<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repositories\ReservationRepository;

class ReservationService
{
    private ReservationRepository $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
    }

    public function createReservation(Reservation $reservation)
    {
        return $this->reservationRepository->createReservation($reservation);
    }

    /**
     * Summary of updateReservationStatus
     * @param mixed $reservation_id
     * @param mixed $status
     * @return bool
     */
    public function updateReservationStatus($reservation_id, $status)
    {
        return $this->reservationRepository->updateReservationStatus($reservation_id, $status);
    }

    /**
     * Summary of updateReservation
     * @param mixed $reservation_id
     * @return bool
     */
    public function updateReservation($reservation_id)
    {
        return $this->reservationRepository->updateReservation($reservation_id);
    }

    public function getAllReservations()
    {
        return $this->reservationRepository->getAllReservations();
    }

    /**
     * Summary of getReservationById
     * @param mixed $reservation_id
     */
    public function getReservationById($reservation_id)
    {
        return $this->reservationRepository->getReservationById($reservation_id);
    }

    /**
     * Summary of getReservationsByRestaurantId
     * @param mixed $restaurant_id
     * @return array
     */
    public function getReservationsByRestaurantId($restaurant_id)
    {
        return $this->reservationRepository->getReservationsByRestaurantId($restaurant_id);
    }

    /**
     * Summary of getReservationsByUserId
     * @param mixed $user_id
     * @return array
     */
    public function getReservationsByUserId($user_id)
    {
        return $this->reservationRepository->getReservationsByUserId($user_id);
    }

    /**
     * Summary of deleteReservation
     * @param mixed $reservation_id
     * @return bool
     */
    public function deleteReservation($reservation_id)
    {
        return $this->reservationRepository->deleteReservation($reservation_id);
    }
}
