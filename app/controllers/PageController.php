<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Page;
use App\Models\Section;
use App\Services\PageService;
use App\Services\SectionService;
use Exception;

class PageController
{
    private PageService $pageService;
    private SectionService $sectionService;

    public function __construct()
    {
        $this->pageService = new PageService();
        $this->sectionService = new SectionService();
    }

    public function index()
    {
        try {
            $pages = $this->pageService->getAllPages();
            require_once __DIR__ . '/../views/backend/pages/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        try {
            require_once __DIR__ . '/../views/backend/pages/create.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function store()
    {
        try {
            if (!isset($_POST['title'])) {
                throw new Exception("Title is required for the page.");
            }

            $slug = Helper::slug($_POST['title']);
            $page = new Page($_POST['title'], 1, $slug);
            $pageId = $this->pageService->createPage($page);

            if (isset($_POST['section_title'])) {
                $sectionTitles = $_POST['section_title'];

                foreach ($sectionTitles as $index => $sectionTitle) {
                    if (empty($sectionTitle)) {
                        continue;
                    }

                    $sectionType = isset($_POST['section_type'][$index]) ? $_POST['section_type'][$index] : "";
                    if (empty($sectionType)) {
                        throw new Exception("Section type is required for each section.");
                    }

                    $sectionContent = isset($_POST['section_content'][$index]) ? $_POST['section_content'][$index] : null;
                    $sectionSubTitle = isset($_POST['section_sub_title'][$index]) ? $_POST['section_sub_title'][$index] : null;
                    $mapUrl = isset($_POST['map_url'][$index]) ? $_POST['map_url'][$index] : null;

                    $imageUrl = "";
                    if (isset($_FILES['image_url']['name'][$index], $_FILES['image_url']['tmp_name'][$index]) && $_FILES['image_url']['name'][$index] != "" && $_FILES['image_url']['tmp_name'][$index]) {
                        $fileName = $_FILES['image_url']['name'][$index];
                        $tmpFilePath = $_FILES['image_url']['tmp_name'][$index];

                        $uploadDir = __DIR__ . '/../public/images/';
                        $newFileName = uniqid('', true) . '_' . $fileName;
                        $uploadPath = $uploadDir . $newFileName;

                        if (!move_uploaded_file($tmpFilePath, $uploadPath)) {
                            throw new Exception("Error uploading file: $fileName");
                        }

                        $imageUrl = '/images/' . $newFileName;
                    }

                    $section = new Section($sectionTitle, $sectionSubTitle, $sectionContent, $imageUrl, $mapUrl, $sectionType, $pageId);
                    $this->sectionService->createSection($section);
                }
            } else {
                $_SESSION['isError'] = 1;
                $_SESSION['flash_message'] = "Please provide at least a title for each section!";
                header("Location: /page");
                exit();
            }

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Page and sections created successfully!";
            header("Location: /page");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }


    public function edit()
    {
        try {
            $page_id = $_GET['id'];
            $page = $this->pageService->getPageById($page_id);
            $sections = $this->sectionService->getSectionByPageId($page_id);
            require_once __DIR__ . '/../views/backend/pages/edit.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function update()
    {
        try {
            if (!isset($_POST['page_id']) || !is_numeric($_POST['page_id'])) {
                throw new Exception("Invalid page ID provided.");
            }

            $pageId = $_POST['page_id'];
            $page = $this->pageService->getPageById($pageId);
            $pageTitle = $_POST['title'] ?? '';

            if (empty($pageTitle)) {
                throw new Exception("Title is required for the page.");
            }

            $slug = Helper::slug($pageTitle);
            $page = new Page($pageTitle, 1, $slug, $pageId);
            $this->pageService->updatePage($page, $pageId);

            $sections = $this->sectionService->getSectionByPageId($pageId);

            if (isset($_POST['section_title'])) {
                $sectionTitles = $_POST['section_title'];

                foreach ($sectionTitles as $index => $sectionTitle) {
                    if (empty($sectionTitle)) {
                        continue;
                    }

                    $sectionType = $_POST['section_type'][$index] ?? "";
                    if (empty($sectionType)) {
                        throw new Exception("Section type is required for each section.");
                    }

                    $sectionContent = $_POST['section_content'][$index] ?? null;
                    $sectionSubTitle = $_POST['section_sub_title'][$index] ?? null;
                    $mapUrl = $_POST['map_url'][$index] ?? null;

                    $imageUrl = "";
                    if (isset($_FILES['image_url']['name'][$index], $_FILES['image_url']['tmp_name'][$index]) && $_FILES['image_url']['name'][$index] != "" && $_FILES['image_url']['tmp_name'][$index]) {
                        $fileName = $_FILES['image_url']['name'][$index];
                        $tmpFilePath = $_FILES['image_url']['tmp_name'][$index];

                        $uploadDir = __DIR__ . '/../public/images/';
                        $newFileName = uniqid('', true) . '_' . $fileName;
                        $uploadPath = $uploadDir . $newFileName;

                        if (!move_uploaded_file($tmpFilePath, $uploadPath)) {
                            throw new Exception("Error uploading file: $fileName");
                        }

                        $imageUrl = '/images/' . $newFileName;
                    }

                    if (isset($_POST['section_id'][$index]) && is_numeric($_POST['section_id'][$index])) {
                        $sectionId = $_POST['section_id'][$index];
                        $imageUrl = $imageUrl == "" ? $this->sectionService->getSectionById($sectionId)->getImageUrl() : $imageUrl;

                        $section = new Section($sectionTitle, $sectionSubTitle, $sectionContent, $imageUrl, $mapUrl, $sectionType, $pageId, $sectionId);
                        $this->sectionService->updateSection($section);
                    } else {
                        $section = new Section($sectionTitle, $sectionSubTitle, $sectionContent, $imageUrl, $mapUrl, $sectionType, $pageId);
                        $this->sectionService->createSection($section);
                    }
                }
            } else {
                Helper::setMessage(1, "Please provide at least a title for each section!");
            }

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Page and sections updated successfully!";
            header("Location: /page");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function delete()
    {
        try {
            $page_id = $_GET['id'];
            $this->pageService->deletePage($page_id);
            $_SESSION['isError'] = 1;
            $_SESSION['flash_message'] = "Page deleted successfully!";
            header("Location: /page");
            exit();
        } catch (Exception $e) {
            // Handle error appropriately, e.g., redirect to error page
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function deleteSection()
    {
        try {
            $sectionid = $_GET['id'];
            $this->sectionService->deleteSection($sectionid);
            $existingService = $this->sectionService->getSectionById($sectionid);
            $existingImageUrl = $existingService['image_url'];
            Helper::unlinkImage($existingImageUrl);
            echo "success";
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function status()
    {
        $id = $_GET['id'];
        $isActive = $_POST['active'];
        $page = $this->pageService->getPageById($id);
        $newPage = new Page($page['title'], $isActive, $page['slug']);
        $this->pageService->updatePage($newPage, $id);
    }
}
