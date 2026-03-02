<?php
namespace App\Services;

use App\Models\Dance;
use App\Repositories\DanceRepository;
use Exception;

class DanceService
{
    private DanceRepository $danceRepository;

    public function __construct()
    {
        $this->danceRepository = new DanceRepository();
    }

    public function getAllEvents()
    {
        try {
            return $this->danceRepository->getAll();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}