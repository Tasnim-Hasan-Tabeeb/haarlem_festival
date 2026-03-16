<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Exception;

class ReservationService
{
    private $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
    }

    public function createReservation(Reservation $reservation)
    {
        return $this->reservationRepository->createReservation($reservation);
    }

    public function updateReservationStatus($reservation_id, $status)
    {
        return $this->reservationRepository->updateReservationStatus($reservation_id, $status);
    }

    public function updateReservation($reservation_id)
    {
        return $this->reservationRepository->updateReservation($reservation_id);
    }

    public function getAllReservations()
    {
        return $this->reservationRepository->getAllReservations();
    }

    public function getReservationById($reservation_id)
    {
        return $this->reservationRepository->getReservationById($reservation_id);
    }

    public function getReservationsByRestaurantId($restaurant_id)
    {
        return $this->reservationRepository->getReservationsByRestaurantId($restaurant_id);
    }

    public function getReservationsByUserId($user_id)
    {
        return $this->reservationRepository->getReservationsByUserId($user_id);
    }
}
