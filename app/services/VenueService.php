<?php
namespace App\Services;

use App\Models\Venue;
use App\Repositories\VenueRepository;
use Exception;

class VenueService {

    private VenueRepository $venueRepository;
    public function __construct()
    {
        $this->venueRepository = new VenueRepository();
    }
    public function getAllVenues()
    {
        try {
            return $this->venueRepository->getAll();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getVenuesById(int $venue_id)
    {
        try {
            return $this->venueRepository->getVenuesById($venue_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function updateVenue(Venue $venue, $venue_id): bool
    {
        try {
            return $this->venueRepository->update($venue, $venue_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function storeVenue(Venue $venue)
    {
        try {
            return $this->venueRepository->storeVenue($venue);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function deleteVenue($venue_id)
    {
        try {
            return $this->venueRepository->delete($venue_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}