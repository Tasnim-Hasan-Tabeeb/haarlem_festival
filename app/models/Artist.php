<?php

namespace App\Models;
class Artist
{

    public ?int $artist_id;
    public string $artist_name;
    public string $age;
    public string $nationality;
    public string $genre;
    public string $about;
    public string $image_url;

    public function __construct(?int $artist_id, string $artist_name, string $age, string $nationality, string $genre, string $about, string $image_url)
    {
        $this->artist_id = $artist_id;
        $this->artist_name = $artist_name;
        $this->age = $age;
        $this->nationality = $nationality;
        $this->genre = $genre;
        $this->about = $about;
        $this->image_url = $image_url;
    }

    public function getArtist_id(): int
    {
        return $this->artist_id;
    }
    public function setArtist_id(int $artist_id): void
    {
        $this->artist_id = $artist_id;
    }
    public function getArtist_name(): string
    {
        return $this->artist_name;
    }
    public function setArtist_name(string $artist_name): void
    {
        $this->artist_name = $artist_name;
    }
    public function getAge(): string
    {
        return $this->age;
    }
    public function setAge(string $age): void
    {
        $this->age = $age;
    }
    public function getNationality(): string
    {
        return $this->nationality;
    }
    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }
    public function getGenre(): string
    {
        return $this->genre;
    }
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }
    public function getAbout(): string
    {
        return $this->about;
    }
    public function setAbout(string $about): void
    {
        $this->about = $about;
    }
    public function getImage_url(): string
    {
        return $this->image_url;
    }
    public function setImage_url(string $image_url): void
    {
        $this->image_url = $image_url;
    }

}
