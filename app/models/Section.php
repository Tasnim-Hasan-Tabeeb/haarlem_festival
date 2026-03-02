<?php

namespace App\Models;

class Section
{
    private ?int $section_id;
    private ?string $section_title;
    private ?string $section_sub_title;
    private ?string $content;
    private ?string $image_url;
    private ?string $map_url;
    private string $section_type;
    private int $page_id;

    public function __construct(?string $section_title, ?string $section_sub_title, ?string $content, ?string $image_url, ?string $map_url, ?string $section_type, ?int $page_id, ?int $section_id = null)
    {
        $this->section_id = $section_id;
        $this->section_title = $section_title;
        $this->section_sub_title = $section_sub_title;
        $this->content = $content;
        $this->image_url = $image_url;
        $this->map_url = $map_url;
        $this->section_type = $section_type;
        $this->page_id = $page_id;
    }

    public function getSectionId(): ?int
    {
        return $this->section_id;
    }

    public function setSectionId(?int $section_id): void
    {
        $this->section_id = $section_id;
    }

    public function getSectionTitle(): string
    {
        return $this->section_title;
    }

    public function setSectionTitle(string $section_title): void
    {
        $this->section_title = $section_title;
    }

    public function getSubSectionTitle(): string
    {
        return $this->section_sub_title;
    }

    public function setSubSectionTitle(string $section_sub_title): void
    {
        $this->section_sub_title = $section_sub_title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }

    public function getMapUrl(): string
    {
        return $this->map_url;
    }

    public function setMapUrl(string $map_url): void
    {
        $this->map_url = $map_url;
    }

    public function getSectionType(): string
    {
        return $this->section_type;
    }

    public function setSectionType(string $section_type): void
    {
        $this->section_type = $section_type;
    }

    public function getPageId(): int
    {
        return $this->page_id;
    }

    public function setPageId(int $page_id): void
    {
        $this->page_id = $page_id;
    }
}
