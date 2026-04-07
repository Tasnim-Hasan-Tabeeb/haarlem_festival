<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Helpers\Validator;
use App\Models\Reservation;
use App\Models\User;
use App\Services\Basket;
use App\Services\ReservationService;
use App\Services\RestaurantService;
use App\Services\SessionService;
use App\Services\UserService;
use Exception;

class ReservationController
{
    private $reservationService;
    private $restaurantService;
    private $sessionService;
    private $basket;

    private $userService;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->basket             = new Basket();
        $this->restaurantService  = new RestaurantService();
        $this->sessionService     = new SessionService();
        $this->userService        = new UserService() ;
    }

    public function index()
    {
        try {
            $reservations = $this->reservationService->getAllReservations();
            require __DIR__ . '/../views/backend/reservations/index.php';
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
            header('Location: ' . $redirect);
        }
    }

    public function add()
    {
        try {
            $restaurants = $this->restaurantService->getAllRestaurants();
            require __DIR__ . '/../views/backend/reservations/create.php';
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
            header('Location: ' . $redirect);
        }
    }

    public function create()
    {
        try {
            $rules = [
                'name'             => 'required|string|min:3|max:100',
                'reservation_date' => 'required|date:Y-m-d',
                'total_adult'      => 'required|numeric',
                'total_children'   => 'required|numeric',
                'email'            => 'required|email',
                'phone'            => 'required|min:6|max:20',
                'session_id'       => 'required',
                'restaurant_id'    => 'required|numeric',
            ];

            $validatedData = Validator::validate($_POST, $rules);
            if (!isset($_SESSION['user'])) {
                $_SESSION['isError']       = 1;
                $_SESSION['flash_message'] = 'You must be logged in to checkout';
                $redirect = $_SERVER['HTTP_REFERER'] ?? '/login/login';
                header('Location: ' . $redirect);
                exit();
            }

            $user = $_SESSION['user'];
            $userId = $user['user_id'];
            $name             = $validatedData['name'];
            $reservation_date = $validatedData['reservation_date'];
            $total_adult      = $validatedData['total_adult'];
            $total_children   = $validatedData['total_children'];
            $email            = $validatedData['email'];
            $phone            = $validatedData['phone'];
            $session_id       = $validatedData['session_id'];
            $restaurant_id    = $validatedData['restaurant_id'];
            $remarks          = $_POST['remarks'];
           $cost_per_person = $this->reservationService->calculateCostPerPerson(
                $restaurant_id,
                $total_adult,
                $total_children
            );

            $reservation = new Reservation(
                $name,
                $reservation_date,
                $total_adult,
                $total_children,
                $email,
                $phone,
                $userId, 
                $session_id,
                $restaurant_id,
                $remarks,
                $cost_per_person
            );

            $this->basket->addItem($reservation);
            Helper::setMessage(false, 'Reservation added to basket successfully!');
            header('Location: /personalprogram/basket');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/personalprogram/basket';
            header('Location: ' . $redirect);
        }
    }

    public function updateIsActiveToZero()
    {
        try {
            $reservation_id = $_POST['reservation_id'];
            $this->reservationService->updateReservationStatus($reservation_id, 0);
            Helper::setMessage(false, 'Reservation deactivated successfully!');
            header('Location: /reservation');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/reservation';
            header('Location: ' . $redirect);
        }
    }

    public function updateIsActiveToOne()
    {
        try {
            $reservation_id = $_POST['reservation_id'];
            $this->reservationService->updateReservationStatus($reservation_id, 1);
            Helper::setMessage(false, 'Reservation reactivated successfully!');
            header('Location: /reservation');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/reservation';
            header('Location: ' . $redirect);
        }
    }

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

    public function store()
    {
        try {
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

            $validatedData = Validator::validate($_POST, $rules);
            $name             = $validatedData['name'];
            $reservation_date = $validatedData['reservation_date'];
            $total_adult      = $validatedData['total_adult'];
            $total_children   = $validatedData['total_children'];
            $email            = $validatedData['email'];
            $phone            = $validatedData['phone'];
            $session_id       = $validatedData['session_id'];
            $restaurant_id    = $validatedData['restaurant_id'];
            $remarks          = $_POST['remarks'];
            $cost_per_person = $this->reservationService->calculateCostPerPerson(
                $restaurant_id,
                $total_adult,
                $total_children
            );
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
                $reservation_date,
                $total_adult,
                $total_children,
                $email,
                $phone,
                $user? $user['user_id'] : null,
                $session_id,
                $restaurant_id,
                $remarks,
                $cost_per_person
            );

            $this->reservationService->createReservation($reservation);
            Helper::setMessage(false, 'Reservation created successfully!');
            header('Location: /reservation');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/reservation';
            header('Location: ' . $redirect);
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
                header('Location: /error?message=Invalid reservation ID');
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
            header('Location: ' . $redirect);
        }
    }

    public function update()
    {
        try {
            $rules = [
                'id'               => 'required|numeric',          
                'name'             => 'required|string|min:3|max:100', 
                'reservation_date' => 'required|date:Y-m-d',       
                'total_adult'      => 'required|numeric',         
                'total_children'   => 'required|numeric',         
                'email'            => 'required|email',            
                'phone'            => 'required|string|min:6|max:20', 
                'session_id'       => 'required',           
                'restaurant_id'    => 'required',          
                'remarks'          => 'string|max:500',            
            ];

            $validatedData = Validator::validate($_POST, $rules);
            $reservation_id   = $_POST['id'];
            $name             = $validatedData['name'];
            $reservation_date = $validatedData['reservation_date'];
            $total_adult      = $validatedData['total_adult'];
            $total_children   = $validatedData['total_children'];
            $email            = $validatedData['email'];
            $phone            = $validatedData['phone'];
            $session_id       = $validatedData['session_id'];
            $restaurant_id    = $validatedData['restaurant_id'];
            $remarks          = $_POST['remarks'];
           $cost_per_person = $this->reservationService->calculateCostPerPerson(
                $restaurant_id,
                $total_adult,
                $total_children
            );

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
                $reservation_date,
                $total_adult,
                $total_children,
                $email,
                $phone,
                $user? $user['user_id'] : null, 
                $session_id,
                $restaurant_id,
                $remarks,
                $cost_per_person
            );

            $reservation->setReservationId($reservation_id);
            $this->reservationService->updateReservation($reservation);
            Helper::setMessage(false, 'Reservation updated successfully!');
            header('Location: /reservation');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/reservation';
            header('Location: ' . $redirect);
        }
    }

    public function show()
    {
        try {
            $reservation_id = $_GET['id'];
            $reservation    = $this->reservationService->getReservationById($reservation_id);
            $restaurant     = $this->restaurantService->getRestaurant($reservation['restaurant_id']);
            $session        = $this->sessionService->getSession($reservation['session_id']);
            require __DIR__ . '/../views/backend/reservations/show.php';
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
            header('Location: ' . $redirect);
        }
    }
}
