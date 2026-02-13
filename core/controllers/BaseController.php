<?php

<?php

namespace Core\Controllers;

abstract class BaseController
{

    protected static $instances = [];

    public static function getInstance()
    {
        $class = static::class;

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    protected function basePath($path = '')
    {
        $root = dirname(__DIR__, 2);
        $path = ltrim((string)$path, '/\\');
        return rtrim($root, '/\\') . ($path !== '' ? DIRECTORY_SEPARATOR . $path : '');
    }

    protected function view($file, array $data = [])
    {
        $viewsDir = $this->basePath('core/views');
        $file = trim((string)$file, "/\\");
        $viewFile = $viewsDir . DIRECTORY_SEPARATOR . $file . '.php';
        $layoutFile = $viewsDir . DIRECTORY_SEPARATOR . 'layout.php';

        if (!is_file($viewFile)) {
            http_response_code(500);
            echo "View not found: " . htmlspecialchars($viewFile, ENT_QUOTES, 'UTF-8');
            return;
        }

        if (!is_file($layoutFile)) {
            http_response_code(500);
            echo "Layout not found: " . htmlspecialchars($layoutFile, ENT_QUOTES, 'UTF-8');
            return;
        }

        extract($data, EXTR_SKIP);
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        include $layoutFile;
    }

    protected function screen($name, array $data = [])
    {
        return $this->view($name, $data);
    }

    protected function redirect($to, $status = 302)
    {
        http_response_code((int)$status);
        header('Location: ' . (string)$to);
        exit;
    }

    protected function json($payload, $status = 200)
    {
        http_response_code((int)$status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function input($key, $default = null)
    {
        if (isset($_POST[$key])) return $_POST[$key];
        if (isset($_GET[$key])) return $_GET[$key];
        return $default;
    }
}
