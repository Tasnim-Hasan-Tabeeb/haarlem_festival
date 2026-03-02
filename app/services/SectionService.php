<?php

namespace App\Services;

use App\Models\Section;
use App\Repositories\SectionRepository;

class SectionService
{
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
}
