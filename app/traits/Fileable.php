<?php

namespace App\Traits;

use Exception;

trait Fileable
{
    /**
     * Summary of uploadImage
     * @param array $file
     * @param string $uploadDir
     * @throws Exception
     * @return string
     */
    protected function uploadImage(array $file, string $uploadDir = '/images/'): string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Upload failed');
        }

        $fullDir = __DIR__ . '/../public' . $uploadDir;

        $newFileName = uniqid('', true) . '_' . $file['name'];
        $uploadPath  = $fullDir . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Error uploading file');
        }

        return $uploadDir . $newFileName;
    }

    /**
     * Summary of unlinkImage
     * @param mixed $imageUrl
     * @return void
     */
    protected function unlinkImage($imageUrl)
    {
        if (empty($imageUrl)) return;

        if (str_contains($imageUrl, 'default.webp')) return;

        $path = ltrim($imageUrl, '/');

        if (file_exists($path) && is_file($path)) {
            unlink($path);
        }
    }
}
