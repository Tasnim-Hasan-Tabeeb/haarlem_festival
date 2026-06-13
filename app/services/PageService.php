<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Helpers\Validator;
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

    /**
     * Summary of createPage
     * @throws Exception
     * @return int
     */
    public function createPage(): int
    {
        try {
            $rules = [
                'title'             => 'required|string|min:3|max:500',
                'section_title'     => 'required_array|string|min:3|max:500',
                'section_type'      => 'required_array|string',
                'section_content'   => 'array|string',
                'section_sub_title' => 'array|string|max:150',
                'map_url'           => 'array|string',
            ];
            Validator::validate($_POST, $rules);
            $slug = Helper::slug($_POST['title']);
            $page = new Page($_POST['title'], 1, $slug);

            return $this->pageRepository->create($page);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updatePage
     * @throws Exception
     * @return bool
     */
    public function updatePage(): bool
    {
        try {
            $rules = [
                'page_id'           => 'required|numeric',
                'title'             => 'required|string|min:3|max:500',
                'section_title'     => 'required_array|string|min:3|max:500',
                'section_type'      => 'required_array|string',
                'section_content'   => 'array|string',
                'section_sub_title' => 'array|string|max:150',
                'map_url'           => 'array|string',
            ];

            Validator::validate($_POST, $rules);

            $pageId    = $_POST['page_id'];
            $page      = $this->getPageById($pageId);
            $pageTitle = $_POST['title'];
            $slug      = ($page['slug'] == 'home') ? 'home' : Helper::slug($pageTitle);
            $page      = new Page($pageTitle, 1, $slug, $pageId);

            return $this->pageRepository->update($page, $pageId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getPageBySlug(string $slug)
    {
        return $this->pageRepository->findBySlug($slug);
    }

    /**
     * Summary of updatePageStatus
     * @return bool
     */
    public function updatePageStatus(): bool
    {
        $id       = $_GET['id'];
        $isActive = $_POST['active'];
        $page     = $this->getPageById($id);
        $newPage  = new Page($page['title'], $isActive, $page['slug']);
        return $this->pageRepository->update($newPage, $id);
    }

    /**
     * Summary of deletePage
     * @param int $page_id
     * @throws Exception
     * @return bool
     */
    public function deletePage(int $page_id): bool
    {
        try {
            return $this->pageRepository->delete($page_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getPageById
     * @param int $page_id
     * @throws Exception
     */
    public function getPageById(int $page_id)
    {
        try {
            return $this->pageRepository->getById($page_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getAllActive
     * @throws Exception
     * @return array
     */
    public function getAllActive()
    {
        try {
            return $this->pageRepository->getAllActive();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getAllPages
     * @throws Exception
     * @return array
     */
    public function getAllPages()
    {
        try {
            return $this->pageRepository->getAllPages();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
  }
