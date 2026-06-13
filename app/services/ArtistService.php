<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Artist;
use App\Repositories\ArtistRepository;
use App\Traits\Fileable;
use Exception;
class ArtistService
{
    use Fileable;
    private ArtistRepository $artistRepository;

    public function __construct()
    {
        $this->artistRepository = new ArtistRepository();
    }

    public function getAllArtists()
    {
        try {
            return $this->artistRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
    public function getArtistsById(int $artist_id)
    {
        try {
            return $this->artistRepository->getArtistsById($artist_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateArtist
     * @throws Exception
     * @return bool
     */
    public function updateArtist(): bool
    {
        try {
            $rules = [
                'artist_id'    => 'required|numeric',
                'name'         => 'required|string|min:2|max:100',
                'real-name'    => 'required|string|min:2|max:100',
                'age'          => 'required|numeric|min:1|max:120',
                'nationality'  => 'required|string|min:2|max:100',
                'genre'        => 'required|string|min:2|max:100',
                'about'        => 'required|string|min:10|max:1000',
                'image_url'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max_size:2048',
                'detail_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max_size:4096',
            ];

            Validator::validate($_POST, $rules);

            $artistId = $_POST['artist_id'];

            $artist = $this->getArtistsById($artistId);

            if(!$artist){
                //this will throw an exception and controller will handle it
                throw new Exception('Artist not found');
            }

            $imageUrl    = $artist['image_url'];
            $detailImage = $artist['detail_image'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($imageUrl);
                $file     = $_FILES['image_url'];
                $imageUrl = $this->uploadImage($file);
            }

            if (isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($detailImage);
                $file        = $_FILES['detail_image'];
                $detailImage = $this->uploadImage($file);
            }

            $artist = new Artist(
                null,
                $_POST['name'],
                $_POST['real-name'],
                $_POST['age'],
                $_POST['nationality'],
                $_POST['genre'],
                $_POST['about'],
                $imageUrl,
                $detailImage
            );

            return $this->artistRepository->update($artist, $artistId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of storeArtist
     * @throws Exception
     * @return bool
     */
    public function storeArtist()
    {
        try {
            $rules = [
                'name'         => 'required|string|min:2|max:100',
                'real-name'    => 'required|string|min:2|max:100',
                'age'          => 'required|numeric|min:1|max:120',
                'nationality'  => 'required|string|min:2|max:100',
                'genre'        => 'required|string|min:2|max:100',
                'about'        => 'required|string|min:10|max:1000',
                'image_url'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max_size:2048',
                'detail_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max_size:4096',
            ];

            Validator::validate($_POST, $rules);

            $imageUrl    = null;
            $detailImage = null;

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file     = $_FILES['image_url'];
                $imageUrl = $this->uploadImage($file);
            }

            if (isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['detail_image'];

                $detailImage = $this->uploadImage($file);
            }

            $artist = new Artist(
                null,
                $_POST['name'],
                $_POST['real-name'],
                $_POST['age'],
                $_POST['nationality'],
                $_POST['genre'],
                $_POST['about'],
                $imageUrl,
                $detailImage
            );

            return $this->artistRepository->storeArtist($artist);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteArtist
     * @param mixed $artistId
     * @throws Exception
     * @return bool
     */
    public function deleteArtist($artistId)
    {
        try {
            $artist = $this->getArtistsById($artistId);
            $this->unlinkImage($artist['image_url']);
            $this->unlinkImage($artist['detail_image']);
            return $this->artistRepository->deleteArtist($artistId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getArtistsAlbum
     * @param mixed $artistID
     * @throws Exception
     * @return array
     */
    public function getArtistsAlbum($artistID)
    {
        try {
            return $this->artistRepository->getArtistsAlbum($artistID);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getArtistMusic
     * @param mixed $artistID
     * @throws Exception
     * @return array
     */
    public function getArtistMusic($artistID)
    {
        try {
            return $this->artistRepository->getArtistMusic($artistID);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getArtistAwards
     * @param mixed $artistID
     * @throws Exception
     * @return array
     */
    public function getArtistAwards($artistID)
    {
        try {
            return $this->artistRepository->getArtistAwards($artistID);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
