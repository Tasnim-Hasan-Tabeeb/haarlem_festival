<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\ArtistService;
use App\Services\Basket;
use App\Services\DanceService;
use Exception;

class DanceController extends Controller
{
    private DanceService $danceService;
    private ArtistService $artistService;
    private Basket $basket;

    public function __construct()
    {
        $this->danceService  = new DanceService();
        $this->artistService = new ArtistService();
        $this->basket        = new Basket();
    }

    public function index()
    {
        return $this->redirect('/home/page?slug=dance&id=5');
    }

    /**
     * Summary of artists
     */
    public function artists()
    {
        try {
            $artistID     = $_GET['id'];
            $artists      = $this->artistService->getArtistsById($artistID);
            $artistEvents = $this->danceService->getEventsByArtistId($artistID);
            $artistAlbums = $this->artistService->getArtistsAlbum($artistID);
            $artistMusic  = $this->artistService->getArtistMusic($artistID);

            return View::make('frontend.dance.artists', compact('artists', 'artistEvents', 'artistAlbums', 'artistMusic'));
        } catch (Exception $ex) {
            return $this->handleException($ex);
        }
    }

    /**
     * Summary of addPassToBasket
     * @return void
     */
    public function addPassToBasket()
    {
        try {
            $pass = $this->danceService->createPass();
            $this->basket->addItem($pass);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $dance = $this->danceService->createDanceForCart();
            $this->basket->addItem($dance);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
