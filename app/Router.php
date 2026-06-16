<?php

namespace App;

use App\Helpers\View;
use Error;

class Router
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    private function parseUri($uri)
    {
        $uri         = ltrim($uri, '/');
        $explodedUri = explode('/', $uri);
        return $explodedUri;
    }

    public function route($uri)
    {
        $uri         = $this->stripParameters($uri);
        $explodedUri = $this->parseUri($uri);

        if (empty($explodedUri[0])) {
            $explodedUri[0] = 'home';
        }

        $controllerName = 'App\\Controllers\\' . ucwords($explodedUri[0]) . 'Controller';

        if (isset($explodedUri[1])) {
            $methodName = $explodedUri[1];
        } else {
            $methodName = 'index';
        }

        if ($explodedUri[0] == 'api') {
            $controllerName = 'App\\Controllers\\Api\\' . ucwords($explodedUri[1]) . 'Controller';
            $methodName     = $explodedUri[2] ?? 'index';
        }

        if (!class_exists($controllerName) || !method_exists($controllerName, $methodName)) {
            return View::make('errors.404');
        }

        try {
            $controllerObj = new $controllerName();
            $controllerObj->$methodName();
        } catch (Error $e) {
             var_dump($e->getMessage());
             return View::make('errors.500');
        }
    }
}
