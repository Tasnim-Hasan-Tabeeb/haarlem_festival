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

    public function createPage(Page $page): int
    {
        try {
            return $this->pageRepository->create($page);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function updatePage(Page $page, $page_id): bool
    {
        try {
            return $this->pageRepository->update($page, $page_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deletePage(int $page_id): bool
    {
        try {
            return $this->pageRepository->delete($page_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getPageBySlug(string $slug): ?Page
    {
        try {
            return $this->pageRepository->findBySlug($slug);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getPageById(int $page_id)
    {
        try {
            return $this->pageRepository->getById($page_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
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
