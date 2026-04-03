<?php

namespace App\Services;

use App\Repositories\MusicEventRepository;
use Exception;

class MusicEventService
{
    private MusicEventRepository $musicEventRepository;

    public function __construct()
    {
        $this->musicEventRepository = new MusicEventRepository();
    }

    public function createMusicEvent(array $data): int
    {
        try {
            return $this->musicEventRepository->create($data);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function getAllForManagement(): array
    {
        try {
            return $this->musicEventRepository->getAllForManagement();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getById(int $musicEventId): array
    {
        try {
            return $this->musicEventRepository->getById($musicEventId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function update(int $musicEventId, array $data): bool
    {
        try {
            return $this->musicEventRepository->update($musicEventId, $data);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

}

