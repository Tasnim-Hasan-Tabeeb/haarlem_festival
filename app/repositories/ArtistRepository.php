<?php

namespace App\Repositories;

use App\Models\Artist;
use Exception;
use PDO;
use PDOException;

class ArtistRepository extends Repository
{
    public function getAll()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM artists");
            $stmt->execute();
            $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $artists;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function getArtistsById(int $artist_id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM artists WHERE artist_id = :artist_id");
            $stmt->bindParam(':artist_id', $artist_id);
            $stmt->execute();
            $pageRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return $pageRow;
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function update(Artist $artist, $artist_id): bool
    {
        try {
            $stmt = $this->connection->prepare("UPDATE artists SET artist_name = :artist_name, age = :age, nationality = :nationality, genre = :genre, about = :about, image_url = :image_url, artist_real_name = :artist_real_name, detail_image = :detail_image WHERE artist_id = :artist_id");
            $stmt->execute([
                ':artist_id' => $artist_id,
                ':artist_name' => $artist->getArtist_name(),
                ':artist_real_name' => $artist->getReal_name(),
                ':age' => $artist->getAge(),
                ':nationality' => $artist->getNationality(),
                ':genre' => $artist->getGenre(),
                ':about' => $artist->getAbout(),
                ':image_url' => $artist->getImage_url(),
                ':detail_image' => $artist->getDetail_image(),
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function storeArtist(Artist $artist)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO artists (artist_name, artist_real_name, age, nationality, genre, about, image_url, detail_image) VALUES (:artist_name, :artist_real_name, :age, :nationality, :genre, :about, :image_url, :detail_image)");
            $stmt->execute([
                ':artist_name' => $artist->getArtist_name(),
                ':artist_real_name' => $artist->getReal_name(),
                ':age' => $artist->getAge(),
                ':nationality' => $artist->getNationality(),
                ':genre' => $artist->getGenre(),
                ':about' => $artist->getAbout(),
                ':image_url' => $artist->getImage_url(),
                ':detail_image' => $artist->getDetail_image(),
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }

    }
    public function deleteArtist($artist_id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM artists WHERE artist_id = :artist_id");
            $stmt->bindParam(':artist_id', $artist_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getArtistsAlbum($artist_id){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM albums WHERE artist_id = :artist_id");
            $stmt->bindParam(':artist_id', $artist_id);
            $stmt->execute();
            $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $albums;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getArtistMusic($artist_id){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM artist_musics WHERE artist_id = :artist_id");
            $stmt->bindParam(':artist_id', $artist_id);
            $stmt->execute();
            $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $songs;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getArtistAwards($artist_id){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM artist_awards WHERE artist_id = :artist_id");
            $stmt->bindParam(':artist_id', $artist_id);
            $stmt->execute();
            $awards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $awards;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
