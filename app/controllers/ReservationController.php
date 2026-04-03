<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Reservation;
use App\Services\Basket;
use App\Services\ReservationService;
use App\Services\RestaurantService;
use App\Services\SessionService;
use Exception;

class ReservationController
{
    private $reservationService;
    private $restaurantService;
    private $sessionService;
    private $basket;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->basket = new Basket();
        $this->restaurantService = new RestaurantService();
        $this->sessionService = new SessionService();
    }

    public function create()
    {
        try {
            $validatedData = Helper::validate($_POST);

            $name = $validatedData['name'];
            $reservation_date = $validatedData['reservation_date'];
            $total_adult = $validatedData['total_adult'];
            $total_children = $validatedData['total_children'];
            $email = $validatedData['email'];
            $phone = $validatedData['phone'];
            $session_id = $validatedData['session_id'];
            $restaurant_id = $validatedData['restaurant_id'];
            $remarks = $_POST['remarks'];
            $cost_per_person = 10; // Assuming a fixed cost per person

            $reservation = new Reservation(
                $name,
                $reservation_date,
                $total_adult,
                $total_children,
                $email,
                $phone,
                null, // user_id
                $session_id,
                $restaurant_id,
                $remarks,
                $cost_per_person
            );

            $this->basket->addItem($reservation);

            Helper::setMessage(false, "Reservation added to basket successfully!");
            header("Location: /personalprogram/basket");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function updateIsActiveToZero()
    {
        try {
            $reservation_id = $_POST['reservation_id'];
            $this->reservationService->updateReservationStatus($reservation_id, 0);

            Helper::setMessage(false, "Reservation deactivated successfully!");
            header("Location: /reservation");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function updateIsActiveToOne()
    {
        try {
            $reservation_id = $_POST['reservation_id'];
            $this->reservationService->updateReservationStatus($reservation_id, 1);

            Helper::setMessage(false, "Reservation reactivated successfully!");
            header("Location: /reservation");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function index()
    {
        try {
            $reservations = $this->reservationService->getAllReservations();
            require __DIR__ . '/../views/backend/reservations/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function add()
    {
        try {
            $restaurants = $this->restaurantService->getAllRestaurants();
            require __DIR__ . '/../views/backend/reservations/create.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function getByRestaurant()
    {
        try {
            $restaurant_id = $_GET['id'];
            $sessions = $this->sessionService->getSessionsByRestaurantId($restaurant_id);
            echo json_encode($sessions);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function store()
    {
        try {
            $validatedData = Helper::validate($_POST);

            $name = $validatedData['name'];
            $reservation_date = $validatedData['reservation_date'];
            $total_adult = $validatedData['total_adult'];
            $total_children = $validatedData['total_children'];
            $email = $validatedData['email'];
            $phone = $validatedData['phone'];
            $session_id = $validatedData['session_id'];
            $restaurant_id = $validatedData['restaurant_id'];
            $remarks = $_POST['remarks'];
            $cost_per_person = 10;

            $reservation = new Reservation(
                $name,
                $reservation_date,
                $total_adult,
                $total_children,
                $email,
                $phone,
                null,
                $session_id,
                $restaurant_id,
                $remarks,
                $cost_per_person
            );

            $this->reservationService->createReservation($reservation);

            Helper::setMessage(false, "Reservation created successfully!");
            header("Location: /reservation");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        try {
            $reservation_id = $_GET['id'];
            if (isset($reservation_id) && $reservation_id > 0) {
                $reservation = $this->reservationService->getReservationById($reservation_id);
                $restaurants = $this->restaurantService->getAllRestaurants();
                foreach ($restaurants as &$restaurant) {
                    $restaurant['sessions'] = $this->sessionService->getSessionsByRestaurantId($restaurant['restaurant_id']);
                }
                require __DIR__ . '/../views/backend/reservations/edit.php';
            } else {
                header("Location: /error?message=Invalid reservation ID");
                exit();
            }
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function update()
    {
        try {
            $validatedData = Helper::validate($_POST);

            $reservation_id = $_POST['id'];
            $name = $validatedData['name'];
            $reservation_date = $validatedData['reservation_date'];
            $total_adult = $validatedData['total_adult'];
            $total_children = $validatedData['total_children'];
            $email = $validatedData['email'];
            $phone = $validatedData['phone'];
            $session_id = $validatedData['session_id'];
            $restaurant_id = $validatedData['restaurant_id'];
            $remarks = $_POST['remarks'];
            $cost_per_person = 10; // Assuming a fixed cost per person

            $reservation = new Reservation(
                $name,
                $reservation_date,
                $total_adult,
                $total_children,
                $email,
                $phone,
                null, // user_id
                $session_id,
                $restaurant_id,
                $remarks,
                $cost_per_person
            );

            $reservation->setReservationId($reservation_id);

            $this->reservationService->updateReservation($reservation);

            Helper::setMessage(false, "Reservation updated successfully!");
            header("Location: /reservation");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function show()
    {
        try {
            $reservation_id = $_GET['id'];
            $reservation = $this->reservationService->getReservationById($reservation_id);
            $restaurant = $this->restaurantService->getRestaurant($reservation['restaurant_id']);
            $session = $this->sessionService->getSession($reservation['session_id']);
            require __DIR__ . '/../views/backend/reservations/show.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
