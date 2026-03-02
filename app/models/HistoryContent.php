<?php

namespace App\Models;
class HistoryContent
{
    public ?int $id;
    public string $title;
    public string $description;
    public ?string $image;
    public ?string $url;
    public ?SectionType $sectionType;

    public function __construct(?int $id, string $title, string $description, ?string $image, ?string $url, ?SectionType $sectionType)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->url = $url;
        $this->sectionType = $sectionType;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
    public function getSectionType(): SectionType
    {
        return $this->sectionType;
    }
    public function setSectionType(SectionType $sectionType): void
    {
        $this->sectionType = $sectionType;
    }
}