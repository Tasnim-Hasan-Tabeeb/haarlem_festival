<?php

namespace App\Services;

use App\Models\SectionType;
use App\Repositories\HistoryRepository;
use Exception;

class HistoryService
{
    private HistoryRepository $historyRepository;

    public function __construct()
    {
        $this->historyRepository = new HistoryRepository();
    }

    public function getAllTourLocations()
    {
        return $this->historyRepository->getAllTourLocations();
    }
    public function getTourLocationById($id)
    {
        return $this->historyRepository->getTourLocationById($id);
    }
    public function getAllTimeSlots()
    {
        return $this->historyRepository->getAllTimeSlots();
    }

    public function addLocation($location)
    {
        try {
            return $this->historyRepository->addLocation($location);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function updateLocation($location, $id)
    {
        try {
            return $this->historyRepository->updateLocation($location, $id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function deleteLocation($id)
    {
        try {
            return $this->historyRepository->deleteLocation($id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getAllContent(){
        try{
            return $this->historyRepository->getAllContent();
        }catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getContentById($id){
        try{
            return $this->historyRepository->getContentById($id);
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function deleteContent($id){
        try{
            return $this->historyRepository->deleteContent($id);
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function addContent($content){
        try{
            return $this->historyRepository->addContent($content);
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function updateContent($content, $id){
        try{
            return $this->historyRepository->updateContent($content, $id);
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getAllTours(){
        try{
            return $this->historyRepository->getAllTours();
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getHeader()
    {
        try{
            return $this->historyRepository->getPageHeader();
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getIntroduction()
    {
        try{
            return $this->historyRepository->getPageIntroduction();
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getTourInfo()
    {
        try{
            return $this->historyRepository->getTourInformation();
        }catch (Exception $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getRoute()
    {
        try {
            return $this->historyRepository->getTourRoute();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getRegularTicketPrice()
    {
        try {
            return $this->historyRepository->getRegularTicketPrice();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getFamilyTicketPrice()
    {
        try {
            return $this->historyRepository->getFamilyTicketPrice();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getHistoryPageInfoBySectionType(SectionType $sectionType): array
    {
        $section = SectionType::getSectionType($sectionType);
        try {
            return $this->historyRepository->getHistoryPageInfoBySectionType($section);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getFilteredTours($language_name, $availableGuides)
    {
        try {
            return $this->historyRepository->getFilteredTours($language_name, $availableGuides);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getOrderedTours(){
        try {
            return $this->historyRepository->getOrderedTours();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}