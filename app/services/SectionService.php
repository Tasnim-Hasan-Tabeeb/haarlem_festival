<?php

namespace App\Services;

use App\Models\Section;
use App\Repositories\SectionRepository;
use App\Traits\Fileable;
use Exception;

class SectionService
{
    use Fileable;
    private SectionRepository $sectionRepository;

    public function __construct()
    {
        $this->sectionRepository = new SectionRepository();
    }

    public function createSection(Section $data): bool
    {
        $section = new Section($data->getSectionTitle(), $data->getSubSectionTitle(), $data->getContent(), $data->getImageUrl(), $data->getMapUrl(), $data->getSectionType(), $data->getPageId());
        return $this->sectionRepository->create($section);
    }

    public function updateSection(Section $data): bool
    {
        $section = new Section($data->getSectionTitle(), $data->getSubSectionTitle(), $data->getContent(), $data->getImageUrl(), $data->getMapUrl(), $data->getSectionType(), $data->getPageId(), $data->getSectionId());
        return $this->sectionRepository->update($section);
    }

    public function deleteSection(int $section_id): bool
    {
        return $this->sectionRepository->delete($section_id);
    }

    public function getSectionById(int $section_id): ?Section
    {
        return $this->sectionRepository->getById($section_id);
    }

    public function getSectionByPageId(int $page_id)
    {
      return $this->sectionRepository->getAllByPageId($page_id);
    }

    /**
     * Summary of saveOrUpdateSection
     * @param array $data
     * @param int $pageId
     * @throws Exception
     * @return void
     */
    public function saveOrUpdateSection(array $data, int $pageId): void
    {
        if (empty($data['title'])) {
            return;
        }

        if (empty($data['type'])) {
            throw new Exception('Section type is required for each section.');
        }

        $imageUrl = '';

        if (!empty($data['image_file'])) {
            $imageUrl = $this->uploadImage($data['image_file']);
        }

        $sectionId = $data['section_id'];

        if ($sectionId) {
            $existing = $this->getSectionById($sectionId);

            if (!$imageUrl) {
                $imageUrl = $existing->getImageUrl();
            }

            $section = new Section(
                $data['title'],
                $data['sub_title'],
                $data['content'],
                $imageUrl,
                $data['map_url'],
                $data['type'],
                $pageId,
                $sectionId
            );

            $this->updateSection($section);

            return;
        }

        $section = new Section(
            $data['title'],
            $data['sub_title'],
            $data['content'],
            $imageUrl,
            $data['map_url'],
            $data['type'],
            $pageId
        );

        $this->createSection($section);
    }
}
