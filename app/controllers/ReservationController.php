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

use function PHPSTORM_META\type;

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
            $rules = [
                'reservation_date' => 'required|date:Y-m-d',
                'total_adult'      => 'nullable|numeric|min:0|max:10000',
                'total_children'   => 'nullable|numeric|min:0|max:10000',
                'session_id'       => 'required',
                'restaurant_id'    => 'required|numeric',
                'phone'            => 'required|string',
            ];

            // Call our new validator
            $validatedData = Validator::validate($_POST, $rules);

            $userId = null;
            $email  = null;
            $name   = null;
            $phone  = $_POST['phone'];

            $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

            if(!empty($user)){
                $userId = $user['user_id'];
                $email  = $user['email'];
                $name   = $user['name'];
            }

            $reservationDate = $validatedData['reservation_date'];
            $totalAdult      = $validatedData['total_adult']    ?? 0;
            $totalChildren   = $validatedData['total_children'] ?? 0;
            $sessionId       = $validatedData['session_id'];
            $restaurantId    = $validatedData['restaurant_id'];
            $remarks         = $_POST['remarks'];

            $totalAdult    = is_numeric($totalAdult) ? $totalAdult : 0;
            $totalChildren = is_numeric($totalChildren) ? $totalChildren : 0;

            if($totalAdult == 0 && $totalChildren == 0){
                throw new Exception('Please enter at least one person.');
            }

            $restaurant = $this->restaurantService->getRestaurant($restaurantId);

            if($restaurant['number_of_seats'] < $totalAdult + $totalChildren){
                throw new Exception('Maximum number of people is ' . $restaurant['number_of_seats'] . '. Please reduce the number of people.');
            }

            $priceForAdult = $restaurant['price_for_adult'];
            $priceForChild = $restaurant['price_for_child'];
            $totalCost     = ($priceForAdult * $totalAdult) + ($priceForChild * $totalChildren);
            $totalPersons  = $totalAdult                    + $totalChildren;
            $costPerPerson = $totalPersons > 0 ? $totalCost / $totalPersons : 0;

            $reservation = new Reservation(
                $name,
                $reservationDate,
                $totalAdult,
                $totalChildren,
                $email,
                $phone,
                $userId,
                $sessionId,
                $restaurantId,
                $remarks,
                $costPerPerson,
                $restaurant['title'],
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
            $this->validate();
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
            $this->validate(false);
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
     * Summary of validate
     * @param bool $create
     * @return void
     */
    private function validate(bool $create = true)
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
}
