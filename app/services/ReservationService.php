<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Exception;

class ReservationService
{
    private $reservationRepository;
    private $restaurantService;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
        $this->restaurantService = new RestaurantService();
    }

    public function createReservation(Reservation $reservation)
    {
        return $this->reservationRepository->createReservation($reservation);
    }

    public function updateReservationStatus($reservation_id, $status)
    {
        return $this->reservationRepository->updateReservationStatus($reservation_id, $status);
    }

    public function updateReservation(Reservation $reservation)
    {
        return $this->reservationRepository->updateReservation($reservation);
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

    public function calculateCostPerPerson($restaurant_id, $total_adult, $total_children)
    {
        $restaurant = $this->restaurantService->getRestaurant($restaurant_id);

        if (!$restaurant) {
            throw new Exception('Restaurant not found.');
        }

        $priceForAdult = (float) $restaurant['price_for_adult'];
        $priceForChild = (float) $restaurant['price_for_child'];

        $totalCost = ($priceForAdult * $total_adult) + ($priceForChild * $total_children);
        $totalPersons = (int) $total_adult + (int) $total_children;

        return $totalPersons > 0 ? round($totalCost / $totalPersons, 2) : 0;
    }
}