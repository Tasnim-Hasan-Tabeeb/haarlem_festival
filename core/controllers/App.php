<?php
namespace Core\Controllers;

class App
{
    public function screen($name, $data = [])
    {
        return self::view($name, $data);
    }

    public static function view($file, $data = [])
    {
        extract($data);
        ob_start();
        include "./core/Views/{$file}.php";
        $content = ob_get_clean();
        include __DIR__ . "/../Views/layout.php";
    }
}