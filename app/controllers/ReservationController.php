<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\Validator;
use App\Helpers\View;
use App\Models\Reservation;
use App\Models\User;
use App\Services\Basket;
use App\Services\ReservationService;
use App\Services\RestaurantService;
use App\Services\SessionService;
use App\Services\UserService;
use Exception;

class ReservationController extends Controller
{
    private ReservationService $reservationService;
    private RestaurantService $restaurantService;
    private SessionService$sessionService;
    private Basket $basket;

    private UserService $userService;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->basket             = new Basket();
        $this->restaurantService  = new RestaurantService();
        $this->sessionService     = new SessionService();
        $this->userService        = new UserService() ;
    }

    /**
     * Summary of makeReservation
     * @throws Exception
     */
    public function makeReservation()
    {
        try {
            $data     = $this->reservationService->validateReservationRequest();
            $userData = $this->reservationService->getReservationUserData();
            $this->reservationService->validatePersonCount(
                $data['total_adult']    ?? 0,
                $data['total_children'] ?? 0
            );

            $restaurant = $this->getValidatedRestaurant(
                $data['restaurant_id'],
                $data['total_adult']    ?? 0,
                $data['total_children'] ?? 0
            );

            $reservation = $this->reservationService->buildReservation(
                $data,
                $userData,
                $restaurant
            );

            $this->basket->addItem($reservation);
            return $this->success('Reservation added to basket successfully!', '/personalprogram/basket');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of updateIsActiveToZero
     */
    public function updateIsActiveToZero()
    {
        try {
            $reservation_id = $_POST['reservation_id'];
            $this->reservationService->updateReservationStatus($reservation_id, 0);
            return $this->success('Reservation deactivated successfully!', '/reservation');
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of updateIsActiveToOne
     */
    public function updateIsActiveToOne()
    {
        try {
            $reservation_id = $_POST['reservation_id'];
            $this->reservationService->updateReservationStatus($reservation_id, 1);

            return $this->success('Reservation activated successfully!', '/reservation');
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $reservations = $this->reservationService->getAllReservations();
            return View::make('backend.reservations.index', compact('reservations'));
        } catch (Exception $e) {
           return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            $restaurants = $this->restaurantService->getAllRestaurants();
            return View::make('backend.reservations.create', compact('restaurants'));
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of getByRestaurant
     * @return void
     */
    public function getByRestaurant()
    {
        try {
            $restaurant_id = $_GET['id'];
            $sessions      = $this->sessionService->getSessionsByRestaurantId($restaurant_id);
            echo json_encode($sessions);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->reservationService->validate();
            $this->reservationService->createReservation($this->prepPostData());
            return $this->success('Reservation created successfully!', '/reservation');
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $reservation_id = $_GET['id'];
            $reservation    = $this->reservationService->getReservationById($reservation_id);
            $restaurants    = $this->restaurantService->getAllRestaurants();
            foreach ($restaurants as &$restaurant) {
                $restaurant['sessions'] = $this->sessionService->getSessionsByRestaurantId($restaurant['restaurant_id']);
            }

            return View::make('backend.reservations.edit', compact('reservation', 'restaurants'));
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
            $this->reservationService->validate(false);
            $reservationId = $_POST['id'];
            $reservation   = $this->prepPostData();
            $reservation->setReservationId($reservationId);
            $this->reservationService->updateReservation($reservation);

            return $this->success('Reservation updated successfully!', '/reservation');
        } catch (Exception $e) {
           return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of show
     */
    public function show()
    {
        try {
            $reservation_id = $_GET['id'];
            $reservation    = $this->reservationService->getReservationById($reservation_id);
            $restaurant     = $this->restaurantService->getRestaurant($reservation['restaurant_id']);
            $session        = $this->sessionService->getSession($reservation['session_id']);
            return View::make('backend.reservations.show', compact('reservation', 'restaurant', 'session'));
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of delete
     */
    public function delete(){
        try {
            $reservationId = $_GET['id'];
            $this->reservationService->deleteReservation($reservationId);
            return $this->success('Reservation deleted successfully!', '/reservation');
        } catch (Exception $e) {
            return $this->handleException($e, '/reservation');
        }
    }

    /**
     * Summary of prepPostData
     * @return Reservation
     */
    private function prepPostData()
    {
        $name            = $_POST['name'];
        $reservationDate = $_POST['reservation_date'];
        $totalAdult      = $_POST['total_adult'];
        $totalChildren   = $_POST['total_children'];
        $email           = $_POST['email'];
        $phone           = $_POST['phone'];
        $sessionId       = $_POST['session_id'];
        $restaurantId    = $_POST['restaurant_id'];
        $remarks         = $_POST['remarks'];

        $restaurant = $this->restaurantService->getRestaurant($restaurantId);

        $priceForAdult = $restaurant['price_for_adult'];
        $priceForChild = $restaurant['price_for_child'];

        // Total cost
        $totalCost = ($priceForAdult * $totalAdult) + ($priceForChild * $totalChildren);

        // Cost per person (optional)
        $totalPersons    = $totalAdult + $totalChildren;
        $cost_per_person = $totalPersons > 0 ? $totalCost / $totalPersons : 0;

        $user = $this->userService->getUserByEmail($email);

        if (!$user) {
                $user = new User();
                $user->setName($_POST['name']);
                $user->setEmail($_POST['email']);
                $user->setPassword(password_hash(123123, PASSWORD_DEFAULT));
                $user->setRole('Customer');
                $user->setProfilePicture('');

                $this->userService->storeUser($user);

                $user = $this->userService->getUserByEmail($email);
        }

        $reservation = new Reservation(
            $name,
            $reservationDate,
            $totalAdult,
            $totalChildren,
            $email,
            $phone,
            $user ? $user['user_id'] : null,
            $sessionId,
            $restaurantId,
            $remarks,
            $cost_per_person
        );

        return $reservation;
    }

    private function getValidatedRestaurant(
        int $restaurantId,
        int $totalAdult,
        int $totalChildren
    ): array {
        $restaurant = $this->restaurantService->getRestaurant($restaurantId);

        $totalPersons = $totalAdult + $totalChildren;

        if ($restaurant['number_of_seats'] < $totalPersons) {
            throw new Exception(
                'Maximum number of people is ' .
                $restaurant['number_of_seats'] .
                '. Please reduce the number of people.'
            );
        }

        return $restaurant;
    }
}
