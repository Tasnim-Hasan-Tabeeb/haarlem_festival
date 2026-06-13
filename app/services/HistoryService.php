<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\HistoryContent;
use App\Models\Location;
use App\Models\SectionType;
use App\Repositories\HistoryRepository;
use App\Traits\Fileable;
use Exception;

class HistoryService
{
    use Fileable;
    private HistoryRepository $historyRepository;

    public function __construct()
    {
        $this->historyRepository = new HistoryRepository();
    }

    public function getAllTourLocations()
    {
        return $this->historyRepository->getAllTourLocations();
    }

    /**
     * Summary of getTourLocationById
     * @param mixed $id
     */
    public function getTourLocationById($id)
    {
        return $this->historyRepository->getTourLocationById($id);
    }

    public function getAllLanguages()
    {
        return $this->historyRepository->getAllLanguages();
    }

    public function getAllTimeSlots()
    {
        return $this->historyRepository->getAllTimeSlots();
    }

    /**
     * Summary of addTour
     * @return bool
     */
    public function addTour()
    {
        $rules = [
            'language_id'      => 'required|numeric',
            'timetable_id'     => 'required|numeric',
            'available_guides' => 'required|numeric|min:1|max:10000',
        ];

        Validator::validate($_POST, $rules);

        $timetable_id     = $_POST['timetable_id'];
        $language_id      = $_POST['language_id'];
        $available_guides = $_POST['available_guides'];
        return $this->historyRepository->addTour($timetable_id, $language_id, $available_guides);
    }

    /**
     * Summary of updateTour
     * @throws Exception
     * @return bool
     */
    public function updateTour()
    {
        try {
            $rules = [
                'tour_id'          => 'required|numeric',
                'language_id'      => 'required|numeric',
                'timetable_id'     => 'required|numeric',
                'available_guides' => 'required|numeric|min:1|max:10000',
            ];

            Validator::validate($_POST, $rules);

            $id               = $_POST['tour_id'];
            $timetable_id     = $_POST['timetable_id'];
            $language_id      = $_POST['language_id'];
            $available_guides = $_POST['available_guides'];

            return $this->historyRepository->updateTour($id, $timetable_id, $language_id, $available_guides);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteTour
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function deleteTour($id)
    {
        try {
            return $this->historyRepository->deleteTour($id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getTourById
     * @param mixed $id
     * @throws Exception
     */
    public function getTourById($id)
    {
        try {
            return $this->historyRepository->getTourById($id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of addLocation
     * @throws Exception
     * @return bool
     */
    public function addLocation()
    {
        try {
            $rules = [
                'location_name' => 'required|string|min:3|max:500',
                'description'   => 'required|string|max:1000',
                'image_url'     => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'address'       => 'required|string',
                'contact_info'  => 'required|string'
            ];

            Validator::validate($_POST, $rules);

            $imageUrl = '/images/default.webp';

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file     = $_FILES['image_url'];
                $imageUrl = $this->uploadImage( $file );
            }
            $location = new Location(
                null,
                $_POST['location_name'],
                $_POST['description'],
                $_POST['address'],
                $_POST['contact_info'],
                $imageUrl
            );
            return $this->historyRepository->addLocation($location);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateLocation
     * @throws Exception
     * @return bool
     */
    public function updateLocation()
    {
        try {
             $rules = [
                'tour_location_id' => 'required|integer',
                'location_name'    => 'required|string|min:3|max:500',
                'description'      => 'required|string|max:1000',
                'image_url'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'address'          => 'required|string',
                'contact_info'     => 'required|string'
            ];

            Validator::validate($_POST, $rules);

            $locationId = $_POST['tour_location_id'];
            $location   = $this->getTourLocationById($locationId);
            $image_url  = $location['images'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($image_url);
                $file      = $_FILES['image_url'];
                $image_url = $this->uploadImage( $file );
            }

            $location = new Location(
                (int) $_POST['tour_location_id'],
                $_POST['location_name'],
                $_POST['description'],
                $_POST['address'],
                $_POST['contact_info'],
                $image_url
            );

            return $this->historyRepository->updateLocation($location, $locationId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteLocation
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function deleteLocation($id)
    {
        try {
            $this->unlinkImage($this->getTourLocationById($id)['images']);
            return $this->historyRepository->deleteLocation($id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
    public function getAllContent(){
        try{
            return $this->historyRepository->getAllContent();
        }catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getContentById
     * @param mixed $id
     * @throws Exception
     */
    public function getContentById($id){
        try{
            return $this->historyRepository->getContentById($id);
        }catch (Exception $e){
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteContent
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function deleteContent($id){
        try{
            $this->unlinkImage($this->getContentById($id)['image']);
            return $this->historyRepository->deleteContent($id);
        }catch (Exception $e){
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of addContent
     * @throws Exception
     * @return bool
     */
    public function addContent(){
        try{
            $rules = [
                'title'        => 'required|string|min:3|max:500',
                'description'  => 'nullable|string|max:1000',
                'image_url'    => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'url'          => 'required|url',
                'section_type' => 'required|string'
            ];

            Validator::validate($_POST, $rules);

            $image = '/images/default.webp';
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file  = $_FILES['image_url'];
                $image = $this->uploadImage($file);
            }
            $content = new HistoryContent(
                null,
                $_POST['title'],
                $_POST['description'],
                $image,
                $_POST['url'],
                $_POST['section_type']
            );

            return $this->historyRepository->addContent($content);
        }catch (Exception $e){
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateContent
     * @throws Exception
     * @return bool
     */
    public function updateContent(){
        try{
            $rules = [
                'content_id'   => 'required|numeric',
                'title'        => 'required|string|min:3|max:500',
                'description'  => 'nullable|string|max:1000',
                'image_url'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'url'          => 'required|url',
                'section_type' => 'required|string'
            ];

            Validator::validate($_POST, $rules);

            $contentId = $_POST['content_id'];
            $content   = $this->getContentById($contentId);
            $image     = $content['image'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($image);
                $file  = $_FILES['image_url'];
                $image = $this->uploadImage($file);
            }

            $content = new HistoryContent(
                $contentId,
                $_POST['title'],
                $_POST['description'],
                $image,
                $_POST['url'],
                $_POST['section_type']
            );

            return $this->historyRepository->updateContent($content, $contentId);
        }catch (Exception $e){
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getAllTours(){
        try{
            return $this->historyRepository->getAllTours();
        }catch (Exception $e){
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getHistoryPageInfoBySectionType(SectionType | string $sectionType): array
    {
        $section = SectionType::getSectionType($sectionType);
        try {
            return $this->historyRepository->getHistoryPageInfoBySectionType($section);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getFilteredTours
     * @param mixed $language_name
     * @param mixed $availableGuides
     * @throws Exception
     * @return array
     */
    public function getFilteredTours($language_name, $availableGuides)
    {
        try {
            return $this->historyRepository->getFilteredTours($language_name, $availableGuides);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
    public function getOrderedTours(){
        try {
            return $this->historyRepository->getOrderedTours();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
