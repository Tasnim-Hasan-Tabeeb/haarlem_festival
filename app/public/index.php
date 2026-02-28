<?php

use App\Router;

require '../vendor/autoload.php';

session_start();

$uri = $_SERVER['REQUEST_URI'];

$router = new Router();
$router->route($uri);