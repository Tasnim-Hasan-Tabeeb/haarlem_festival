<?php

ob_start();

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);

ini_set('log_errors', 1);

define('APP_DEBUG', true);

use App\Router;

require '../vendor/autoload.php';

session_start();

$uri = $_SERVER['REQUEST_URI'];

$router = new Router();
$router->route($uri);

ob_end_flush();
