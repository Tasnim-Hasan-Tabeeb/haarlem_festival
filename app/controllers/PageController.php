<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\Helper;
use App\Helpers\View;
use App\Services\PageService;
use App\Services\SectionService;
use Exception;

class PageController extends Controller
{
    private PageService $pageService;
    private SectionService $sectionService;

    public function __construct()
    {
        $this->pageService    = new PageService();
        $this->sectionService = new SectionService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $pages = $this->pageService->getAllPages();
            return View::make('backend.pages.index', compact('pages'));
        } catch (Exception $e) {
            return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            return View::make('backend.pages.create');
        } catch (Exception $e) {
           return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of store
     * @throws Exception
     */
    public function store()
    {
        try {
            $pageId        = $this->pageService->createPage();
            $sectionTitles = isset($_POST['section_title']) ? $_POST['section_title'] : [];

            foreach ($sectionTitles as $index => $sectionTitle) {
                $data = $this->buildSectionData($index);
                $this->sectionService->saveOrUpdateSection($data, $pageId);
            }
           return $this->success('Page and sections created successfully!', '/page');
        } catch (Exception $e) {
            return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $pageId   = $_GET['id'];
            $page     = $this->pageService->getPageById($pageId);
            $sections = $this->sectionService->getSectionByPageId($pageId);
            return View::make('backend.pages.edit', compact('page', 'sections'));
        } catch (Exception $e) {
            return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of update
     * @throws Exception
     */
    public function update()
    {
        try {
            $this->pageService->updatePage();

            $sectionTitles = isset($_POST['section_title']) ? $_POST['section_title'] : [];

            foreach ($sectionTitles as $index => $sectionTitle) {
                $data = $this->buildSectionData($index);
                $this->sectionService->saveOrUpdateSection($data, $_POST['page_id']);
            }
            return $this->success('Page and sections update successfully!', '/page');
        } catch (Exception $e) {
            return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $pageId = $_GET['id'];
            $this->pageService->deletePage($pageId);
            return $this->success('Page deleted successfully!', '/page');
        } catch (Exception $e) {
            return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of deleteSection
     */
    public function deleteSection()
    {
        try {
            $sectionid = $_GET['id'];

            $existingService = $this->sectionService->getSectionById($sectionid);

            if (!$existingService) {
                // this will cause exception and return as error message in catch block
                throw new Exception('Section not found');
            }

            $existingImageUrl = $existingService->getImageUrl();

            if (!empty($existingImageUrl)) {
                Helper::unlinkImage($existingImageUrl);
            }

            $this->sectionService->deleteSection($sectionid);
            echo 'success';
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Summary of status
     */
    public function status()
    {
        try {
            $this->pageService->updatePageStatus();
        } catch (Exception $e) {
            return $this->handleException($e, '/page');
        }
    }

    /**
     * Summary of buildSectionData
     * @param int $index
     * @return array{content: mixed, image_file: mixed, image_tmp: mixed, map_url: mixed, section_id: mixed, sub_title: mixed, title: mixed, type: mixed}
     */
    private function buildSectionData(int $index): array
    {
        $imageFile = null;

        if (isset($_FILES['image_url']['name'][$index]) && $_FILES['image_url']['error'][$index] === UPLOAD_ERR_OK) {
            $imageFile = [
                'name'     => $_FILES['image_url']['name'][$index],
                'type'     => $_FILES['image_url']['type'][$index],
                'tmp_name' => $_FILES['image_url']['tmp_name'][$index],
                'error'    => $_FILES['image_url']['error'][$index],
                'size'     => $_FILES['image_url']['size'][$index],
            ];
        }

        return [
            'title'      => $_POST['section_title'][$index]     ?? '',
            'type'       => $_POST['section_type'][$index]      ?? '',
            'content'    => $_POST['section_content'][$index]   ?? null,
            'sub_title'  => $_POST['section_sub_title'][$index] ?? null,
            'map_url'    => $_POST['map_url'][$index]           ?? null,
            'image_file' => $imageFile,
            'section_id' => $_POST['section_id'][$index] ?? null,
        ];
    }
}
