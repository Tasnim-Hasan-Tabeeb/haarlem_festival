<?php
use Core\Router;
use Core\Controllers\App;
use Core\Controllers\RestaurantController;


//Layout page
Router::get('/', function () {
    $layout = new App();
    $layout->screen('layout', [
        'title' => 'This is main layout', 
    ]);
});

Router::get('/home', function () {
    $homepage = new App();
    $homepage->screen('home', [
         'title' => 'Welcome',
    ]);
});

Router::get('/hello/world', function () {
    $homepage = new App();
    $homepage->screen('homepage', [
        'title' => 'Welcome to home world page',
        'content' => 'This is the hello world.' 
    ]);
});

Router::get('/restaurant', [RestaurantController::class, 'pageView']);





Router::cleanUp();