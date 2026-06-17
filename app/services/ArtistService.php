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
      return $this->artistRepository->getAll();
    }
    public function getArtistsById(int $artist_id)
    {
        return $this->artistRepository->getArtistsById($artist_id);
    }

    /**
     * Summary of updateArtist
     * @throws Exception
     * @return bool
     */
    public function updateArtist(): bool
    {
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
    }

    /**
     * Summary of storeArtist
     * @throws Exception
     * @return bool
     */
    public function storeArtist()
    {
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
    }

    /**
     * Summary of deleteArtist
     * @param mixed $artistId
     * @throws Exception
     * @return bool
     */
    public function deleteArtist($artistId)
    {
        $artist = $this->getArtistsById($artistId);
        $this->unlinkImage($artist['image_url']);
        $this->unlinkImage($artist['detail_image']);
        return $this->artistRepository->deleteArtist($artistId);
    }

    /**
     * Summary of getArtistsAlbum
     * @param mixed $artistID
     * @throws Exception
     * @return array
     */
    public function getArtistsAlbum($artistID)
    {
        return $this->artistRepository->getArtistsAlbum($artistID);
    }

    /**
     * Summary of getArtistMusic
     * @param mixed $artistID
     * @throws Exception
     * @return array
     */
    public function getArtistMusic($artistID)
    {
        return $this->artistRepository->getArtistMusic($artistID);
    }

    /**
     * Summary of getArtistAwards
     * @param mixed $artistID
     * @throws Exception
     * @return array
     */
    public function getArtistAwards($artistID)
    {
        return $this->artistRepository->getArtistAwards($artistID);
    }
}
