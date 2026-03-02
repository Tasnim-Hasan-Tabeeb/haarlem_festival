<?php

namespace App\Services;

use App\Models\Page;
use App\Repositories\PageRepository;
use Exception;

class PageService
{
    private PageRepository $pageRepository;

    public function __construct()
    {
        $this->pageRepository = new PageRepository();
    }

    public function getAllActive()
    {
        try {
            return $this->pageRepository->getAllActive();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    
    public function getAllPages()
    {
        try {
            return $this->pageRepository->getAllPages();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
