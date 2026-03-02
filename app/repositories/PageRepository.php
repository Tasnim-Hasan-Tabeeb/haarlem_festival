<?php

namespace App\Repositories;

use App\Models\Page;
use Exception;
use PDO;
use PDOException;

class PageRepository extends Repository
{

    public function getAllActive()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM pages where active = 1");
            $stmt->execute();
            $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $pages;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    
    public function getAllPages()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM pages");
            $stmt->execute();
            $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $pages;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
