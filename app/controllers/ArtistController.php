<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\ArtistService;
use Exception;

class ArtistController extends Controller
{
    private ArtistService $artistService;

    public function __construct()
    {
        $this->artistService = new ArtistService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $artists = $this->artistService->getAllArtists();
            return View::make('backend.artists.index', compact('artists'));
        } catch (Exception $e) {
            return $this->handleException($e, '/artist');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            return View::make('backend.artists.create');
        } catch (Exception $e) {
            return $this->handleException($e, '/artist');
        }
    }

    /**
     * Summary of store
     * @throws Exception
     */
    public function store()
    {
        try {
            $this->artistService->storeArtist();
            return $this->success('Artist created successfully!', '/artist');
        } catch (Exception $e) {
          return $this->handleException($e, '/artist');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $artist_id = $_GET['id'];
            $artists   = $this->artistService->getArtistsById($artist_id);
            return View::make('backend.artists.edit', compact('artists'));
        } catch (Exception $e) {
            return $this->handleException($e, '/artist');
        }
    }

    /**
     * Summary of update
     * @throws Exception
     */
    public function update()
    {
        try {
            $this->artistService->updateArtist();
            return $this->success('Artist updated successfully!', '/artist');
        } catch (Exception $e) {
            return $this->handleException($e, '/artist');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        $artistId = $_GET['id'];

        try {
            $this->artistService->deleteArtist($artistId);
            return $this->success('Artist deleted successfully!', '/artist');
        } catch (Exception $e) {
            return $this->handleException($e, '/artist');
        }
    }
 }
