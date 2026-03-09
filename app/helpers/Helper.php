<?php

namespace App\Helpers;

use Exception;

class Helper
{
    public static function slug($text, $time = false)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        if ($time) {
            $text = $text . '-' . time();
        }

        return $text;
    }

    public static function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit;
    }

    public static function baseUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $base_url = $protocol . "://" . $host;

        return $base_url;
    }

    public static function uploadFile($file)
    {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];

        if ($fileError === UPLOAD_ERR_OK) {
            $newFileName = uniqid('', true) . '_' . $fileName;
            $uploadPath =  __DIR__ . '/../public/images/' . $newFileName;
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                return '/images/' . $newFileName;
            } else {
                throw new Exception('Error moving uploaded file');
            }
        } else {
            throw new Exception('Error uploading file: ' . $fileError);
        }
    }

    public static function validate($fields)
    {
        $errors = [];
        unset($fields['id']);

        foreach ($fields as $key => $value) {

            if ($key === 'remarks') {
                continue;
            }

            if (is_array($value)) {
                continue;
            }

            if (empty($value) || !isset($value)) {
                $fieldName = str_replace('_', ' ', $key);
                $fieldName = ucwords($fieldName);
                $errors[$key] = "$fieldName is required.";
            } else {
                $fields[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            return false;
        }

        return $fields;
    }

    public static function unlinkImage($imageUrl)
    {
        $unLinkImageUrl = ltrim($imageUrl, '/');
        unlink($unLinkImageUrl);
    }

    /**
     * Set error message in session.
     *
     * @param bool $isError True if it's an error message, false otherwise.
     * @param string $message The message to be set in the session.
     * @return void
     */
    public static function setMessage($isError, $message)
    {
        $_SESSION['isError'] = $isError;
        $_SESSION['flash_message'] = $message;
    }
}
