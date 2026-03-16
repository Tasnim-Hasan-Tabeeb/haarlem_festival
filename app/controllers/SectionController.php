<?php

namespace App\Controllers;

use App\Services\SectionService;
use Exception;

class SectionController
{
    private $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function create()
    {
        // Load the view for creating a new section
    }   

    public function edit($sectionId)
    {
        try {
            $section = $this->sectionService->getSectionById($sectionId);
            // Load the view for editing the section with $section data
        } catch (Exception $e) {
            // Redirect to error page with error message
        }
    }

    public function update()
    {
        try {
            $data = $_POST; // Assuming form data is submitted via POST
            if ($this->sectionService->updateSection($data)) {
                // Success message or redirect to a success page
            } else {
                // Error handling
            }
        } catch (Exception $e) {
            // Redirect to error page with error message
        }
    }

    public function delete($sectionId)
    {
        try {
            if ($this->sectionService->deleteSection($sectionId)) {
                // Success message or redirect to a success page
            } else {
                // Error handling
            }
        } catch (Exception $e) {
            // Redirect to error page with error message
        }
    }
}