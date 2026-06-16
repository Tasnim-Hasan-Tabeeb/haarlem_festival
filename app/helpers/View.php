<?php

namespace App\Helpers;

class View
{
    public static function make($view, $data = [])
    {
        extract($data);

        $path = __DIR__ . '/../views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($path)) {
            throw new \Exception("View not found: $view");
        }

        require $path;
    }
}
