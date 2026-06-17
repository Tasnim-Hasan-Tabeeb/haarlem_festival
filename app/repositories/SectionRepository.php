<?php

namespace App\Repositories;

use App\Models\Section;
use Exception;
use PDO;

class SectionRepository extends Repository
{
    public function create(Section $section): bool
    {
        $stmt = $this->connection->prepare('INSERT INTO sections (section_title, section_sub_title, content, image_url, map_url, section_type, page_id) VALUES (:section_title, :section_sub_title, :content, :image_url, :map_url, :section_type, :page_id)');
        $stmt->execute([
            ':section_title'     => $section->getSectionTitle(),
            ':section_sub_title' => $section->getSubSectionTitle(),
            ':content'           => $section->getContent(),
            ':image_url'         => $section->getImageUrl(),
            ':map_url'           => $section->getMapUrl(),
            ':section_type'      => $section->getSectionType(),
            ':page_id'           => $section->getPageId()
        ]);
        return true;
    }

    public function update(Section $section): bool
    {
        $stmt = $this->connection->prepare('UPDATE sections SET section_title = :section_title, section_sub_title = :section_sub_title, content = :content, image_url = :image_url, map_url = :map_url, section_type = :section_type WHERE section_id = :section_id');
        $stmt->execute([
            ':section_title'     => $section->getSectionTitle(),
            ':section_sub_title' => $section->getSubSectionTitle(),
            ':content'           => $section->getContent(),
            ':image_url'         => $section->getImageUrl(),
            ':map_url'           => $section->getMapUrl(),
            ':section_type'      => $section->getSectionType(),
            ':section_id'        => $section->getSectionId()
        ]);

        return true;
    }

    public function delete(int $section_id): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM sections WHERE section_id = :section_id');
        $stmt->execute([':section_id' => $section_id]);
        return true;
    }

    public function getById(int $section_id): ?Section
    {
        $stmt = $this->connection->prepare('SELECT * FROM sections WHERE section_id = :section_id');
        $stmt->execute([':section_id' => $section_id]);
        $sectionData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($sectionData) {
            return new Section(
                $sectionData['section_title'],
                $sectionData['section_sub_title'],
                $sectionData['content'],
                $sectionData['image_url'],
                $sectionData['map_url'],
                $sectionData['section_type'],
                $sectionData['page_id'],
                $sectionData['section_id']
            );
        }
        return null;
    }

    public function getAllByPageId(int $page_id): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM sections WHERE page_id = :page_id');
        $stmt->execute([':page_id' => $page_id]);
        $sections = [];
        while ($sectionData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sections[] = new Section(
                $sectionData['section_title'],
                $sectionData['section_sub_title'],
                $sectionData['content'],
                $sectionData['image_url'],
                $sectionData['map_url'],
                $sectionData['section_type'],
                $sectionData['page_id'],
                $sectionData['section_id']
            );
        }

        return $sections;
    }
}
