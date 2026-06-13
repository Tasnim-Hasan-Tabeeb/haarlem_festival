<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Venue;
use App\Repositories\VenueRepository;
use App\Traits\Fileable;
use Exception;

class VenueService
{
    use Fileable;
    private VenueRepository $venueRepository;
    public function __construct()
    {
        $this->venueRepository = new VenueRepository();
    }

    /**
     * Summary of getAllVenues
     * @throws Exception
     * @return array
     */
    public function getAllVenues()
    {
        try {
            return $this->venueRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getVenuesById
     * @param int $venue_id
     * @throws Exception
     */
    public function getVenuesById(int $venue_id)
    {
        try {
            return $this->venueRepository->getVenuesById($venue_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of storeVenue
     * @throws Exception
     * @return bool
     */
    public function storeVenue()
    {
        try {
            $rules = [
                'name'        => 'required|string|min:2|max:100',
                'location'    => 'required|string|min:2|max:100',
                'capacity'    => 'required|integer|min:1|max:1000',
                'map_url'     => 'required|url',
                'venue_image' => 'required|image|mimes:jpg,jpeg,png,webp|max_size:2048',
            ];

            Validator::validate($_POST, $rules);

            $imageUrl = null;

            if (isset($_FILES['venue_image']) && $_FILES['venue_image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->uploadImage($_FILES['venue_image']);
            }

            $venue = new Venue(
                null,
                $_POST['name'],
                $_POST['location'],
                $_POST['capacity'],
                $imageUrl,
                $_POST['map_url']
            );

            return $this->venueRepository->storeVenue($venue);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

        /**
         * Summary of updateVenue
         * @throws Exception
         * @return bool
         */
    public function updateVenue(): bool
    {
        try {
            $rules = [
                'venue_id'    => 'required|integer',
                'name'        => 'required|string|min:2|max:100',
                'location'    => 'required|string|min:2|max:100',
                'capacity'    => 'required|integer|min:1|max:1000',
                'map_url'     => 'required|url',
                'venue_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max_size:2048',
            ];

            Validator::validate($_POST, $rules);

            $venue_id = $_POST['venue_id'];

            $venue = $this->getVenuesById($venue_id);

            if (!$venue) {
                // this will throw an exception and will be caught in the controller
                throw new Exception('Venue not found');
            }

            $imageUrl = isset($venue['venue_image']) ? $venue['venue_image'] : '/images/default.webp';

            if (isset($_FILES['venue_image']) && $_FILES['venue_image']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($imageUrl);
                $imageUrl = $this->uploadImage($_FILES['venue_image']);
            }

            $venue = new Venue(
                $venue_id,
                $_POST['name'],
                $_POST['location'],
                $_POST['capacity'],
                $imageUrl,
                $_POST['map_url'],
            );

            return $this->venueRepository->update($venue, $venue_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteVenue
     * @param mixed $venueId
     * @throws Exception
     * @return bool
     */
    public function deleteVenue($venueId)
    {
        try {
            $venue    = $this->getVenuesById($venueId);
            $imageUrl = ($venue['venue_image']);

            if($imageUrl){
               $this->unlinkImage($imageUrl);
            }
            return $this->venueRepository->delete($venueId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
