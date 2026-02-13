<?php
use Core\Router;
use Core\Controllers\App;


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

//Also supports
//Router::get('/price',[Controllername::class,'showPrice']);
//Router::get('/price',"Controllername@showPrice");

Router::cleanUp();