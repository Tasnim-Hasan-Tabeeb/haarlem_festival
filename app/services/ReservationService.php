<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Exception;

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

    public function validate(bool $create = true)
    {
        $rules = [
            'name'             => 'required|string|min:3|max:100',
            'reservation_date' => 'required|date:Y-m-d',
            'total_adult'      => 'required|numeric',
            'total_children'   => 'required|numeric',
            'email'            => 'required|email',
            'phone'            => 'required|string|min:6|max:20',
            'session_id'       => 'required',
            'restaurant_id'    => 'required',
        ];

        if (!$create) {
            $rules['id'] = 'required|numeric';
        }

        Validator::validate($_POST, $rules);
    }

    public function validateReservationRequest(): array
    {
        return Validator::validate($_POST, [
            'reservation_date' => 'required|date:Y-m-d',
            'total_adult'      => 'nullable|numeric|min:0|max:10000',
            'total_children'   => 'nullable|numeric|min:0|max:10000',
            'session_id'       => 'required',
            'restaurant_id'    => 'required|numeric',
            'phone'            => 'required|string',
        ]);
    }

    public function getReservationUserData(): array
    {
        $user = $_SESSION['user'] ?? null;

        return [
            'user_id' => $user ? $user['user_id'] : null,
            'email'   => $user ? $user['email'] : null,
            'name'    => $user ? $user['name']  : null,
        ];
    }

    public function validatePersonCount(
        int|float $totalAdult,
        int|float $totalChildren
    ): void {
        if ((int) $totalAdult === 0 && (int) $totalChildren === 0) {
            throw new Exception('Please enter at least one person.');
        }
    }

    public function buildReservation(
        array $data,
        array $userData,
        array $restaurant
    ): Reservation {
        $totalAdult    = (int) ($data['total_adult'] ?? 0);
        $totalChildren = (int) ($data['total_children'] ?? 0);

        $totalCost = ($restaurant['price_for_adult'] * $totalAdult) + ($restaurant['price_for_child'] * $totalChildren);

        $totalPersons = $totalAdult + $totalChildren;

        $costPerPerson = $totalPersons > 0
            ? $totalCost / $totalPersons
            : 0;

        return new Reservation(
            $userData['name'],
            $data['reservation_date'],
            $totalAdult,
            $totalChildren,
            $userData['email'],
            $data['phone'],
            $userData['user_id'],
            $data['session_id'],
            $data['restaurant_id'],
            $_POST['remarks'] ?? '',
            $costPerPerson,
            $restaurant['title']
        );
    }
}
