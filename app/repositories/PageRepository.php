<?php

namespace App\Repositories;

use App\Models\Page;
use Exception;
use PDO;
use PDOException;

class PageRepository extends Repository
{
    /**
     * Summary of create
     * @param Page $page
     * @throws Exception
     * @return int
     */
    public function create(Page $page): int
    {
        $stmt = $this->connection->prepare('INSERT INTO pages (title, active, slug) VALUES (:title, :active, :slug)');
        $stmt->execute([
            ':title'  => $page->getTitle(),
            ':active' => $page->getActive(),
            ':slug'   => $page->getSlug()
        ]);
        return (int) $this->connection->lastInsertId();
    }

    /**
     * Summary of update
     * @param Page $page
     * @param mixed $page_id
     * @throws Exception
     * @return bool
     */
    public function update(Page $page, $page_id): bool
    {
        $stmt = $this->connection->prepare('UPDATE pages SET title = :title, slug = :slug, active = :active WHERE page_id = :page_id');
        $stmt->execute([
            ':page_id' => $page_id,
            ':title'   => $page->getTitle(),
            ':slug'    => $page->getSlug(),
            ':active'  => $page->getActive()
        ]);
        return true;
    }

    /**
     * Summary of delete
     * @param int $page_id
     * @throws Exception
     * @return bool
     */
    public function delete(int $page_id): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM pages WHERE page_id = :page_id');
        $stmt->execute([':page_id' => $page_id]);
        return true;
    }

    /**
     * Summary of findBySlug
     * @param string $slug
     * @throws Exception
     * @return Page|null
     */
    public function findBySlug(string $slug): ?Page
    {
        $stmt = $this->connection->prepare('SELECT * FROM pages WHERE slug = :slug');
        $stmt->execute([':slug' => $slug]);

        $pageData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pageData) {
            return null;
        }

        return new Page(
            $pageData['title'],
            (int) $pageData['active'],
            $pageData['slug'],
            (int) $pageData['page_id']
        );
    }

    /**
     * Summary of getById
     * @param int $page_id
     * @throws Exception
     */
    public function getById(int $page_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM pages WHERE page_id = :page_id');
        $stmt->bindParam(':page_id', $page_id);
        $stmt->execute();
        $pageRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $pageRow;
        }
        return null;
    }

    /**
     * Summary of getAllActive
     * @throws Exception
     * @return array
     */
    public function getAllActive()
    {
        $stmt = $this->connection->prepare('SELECT * FROM pages where active = 1');
        $stmt->execute();
        $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pages;
    }

    /**
     * Summary of getAllPages
     * @throws Exception
     * @return array
     */
    public function getAllPages()
    {
        $stmt = $this->connection->prepare('SELECT * FROM pages');
        $stmt->execute();
        $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pages;
    }
}
