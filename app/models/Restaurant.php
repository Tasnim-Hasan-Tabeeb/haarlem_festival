<?php

namespace App\Models;

class Restaurant
{
    private int $restaurantId;
    private string $title;
    private string $imageUrl;
    private string $description;
    private float $ratings;
    private string $cuisines;
    private int $eventId;
    private string $location;
    private int $numberOfSeats;
    private string $contactEmail;
    private string $contactPhone;
    private string $galleryImages;

    public function getRestaurantId(): int
    {
        return $this->restaurantId;
    }
    
    public function setRestaurantId(int $restaurantId): void
    {
        $this->restaurantId = $restaurantId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getRatings(): float
    {
        return $this->ratings;
    }

    public function setRatings(float $ratings): void
    {
        $this->ratings = $ratings;
    }

    public function getCuisines(): string
    {
        return $this->cuisines;
    }

    public function setCuisines(string $cuisines): void
    {
        $this->cuisines = $cuisines;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getNumberOfSeats(): int
    {
        return $this->numberOfSeats;
    }

    public function setNumberOfSeats(int $numberOfSeats): void
    {
        $this->numberOfSeats = $numberOfSeats;
    }

    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): void
    {
        $this->contactEmail = $contactEmail;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): void
    {
        $this->contactPhone = $contactPhone;
    }

    public function getGalleryImages(): string
    {
        return $this->galleryImages;
    }

    public function setGalleryImages(string $galleryImages): void
    {
        $this->galleryImages = $galleryImages;
    }
}
