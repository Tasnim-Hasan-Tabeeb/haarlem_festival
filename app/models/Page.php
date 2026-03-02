<?php

namespace App\Models;

class Page
{
    private ?int $page_id;
    private string $title;
    private int $active;
    private ?string $slug;

    public function __construct(string $title, ?int $active = 1, ?string $slug = null, ?int $page_id = null)
    {
        $this->title = $title;
        $this->active = $active !== null ? $active : 1;
        $this->slug = $slug;
        $this->page_id = $page_id;
    }

    public function getPageId(): ?int
    {
        return $this->page_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
