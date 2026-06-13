<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\FeatureService;
use App\Services\RestaurantService;
use App\Services\SessionService;
use Exception;

class RestaurantController extends Controller
{
    private RestaurantService $restaurantService;
    private SessionService $sessionService;
    private FeatureService $featureService;
    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
        $this->sessionService    = new SessionService();
        $this->featureService    = new FeatureService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $restaurants = $this->restaurantService->getAllRestaurants();
            return View::make('backend.restaurants.index', compact('restaurants'));
        } catch (Exception $e) {
            return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of create
     * @return void
     */
    public function create()
    {
        try {
            $events   = $this->sessionService->getAllEvents();
            $features = $this->featureService->getAllFeatures();
            return View::make('backend.restaurants.create', compact('events', 'features'));
        } catch (Exception $e) {
            return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $restaurantId     = $this->restaurantService->createRestaurant();
            $selectedFeatures = isset($_POST['features']) ? $_POST['features'] : [];
            $this->restaurantService->associateFeaturesWithRestaurant($restaurantId, $selectedFeatures);

           return $this->success('Restaurant created successfully', '/restaurant');
        } catch (Exception $e) {
           return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of view
     */
    public function view()
    {
        try {
            $id         = $_GET['id'];
            $restaurant = $this->restaurantService->getRestaurant($id);
            $sessions   = $this->sessionService->getSessionsByRestaurantId($id);
            return View::make('backend.restaurants.view', compact('restaurant', 'sessions'));
        } catch (Exception $e) {
            return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $id               = $_GET['id'];
            $events           = $this->sessionService->getAllEvents();
            $features         = $this->featureService->getAllFeatures();
            $selectedFeatures = $this->featureService->getAllFeaturesByRestaurantId($id);
            $restaurant       = $this->restaurantService->getRestaurant($id);

            return View::make('backend.restaurants.edit', compact('events', 'features', 'selectedFeatures', 'restaurant'));
        } catch (Exception $e) {
            return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
            $id               = $_POST['id'];
            $selectedFeatures = isset($_POST['features']) ? $_POST['features'] : [];
            $this->restaurantService->updateRestaurant();
            $this->featureService->deleteFeatureByRestaurantId($id);
            $this->restaurantService->associateFeaturesWithRestaurant($id, $selectedFeatures);

            return $this->success('Restaurant updated successfully!', '/restaurant');
        } catch (Exception $e) {
           return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $id = $_GET['id'];
            $this->restaurantService->deleteRestaurant($id);
            return $this->success('Restaurant deleted successfully!', '/restaurant');
        }  catch (Exception $e) {
            return $this->handleException($e, '/restaurant');
        }
    }

    /**
     * Summary of details
     */
    public function details()
    {
        try {
            $id         = $_GET['id'];
            $restaurant = $this->restaurantService->getRestaurant($id);
            $sessions   = $this->sessionService->getSessionsByRestaurantId($id);
            return View::make('frontend.yummy.details', compact('restaurant', 'sessions'));
        } catch (Exception $e) {
            return $this->handleException($e, '/');
        }
    }

    /**
     * Summary of unlinkGalleryImage
     */
    public function unlinkGalleryImage()
    {
        try {
            $id = $_GET['id'];
            $this->restaurantService->unlinkGalleryImage($id);
            return $this->redirectBack();
        } catch (Exception $e) {
            return $this->handleException($e, '/restaurant');
        }
    }
}
