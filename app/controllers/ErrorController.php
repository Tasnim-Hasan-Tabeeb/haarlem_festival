<?php

namespace App\Controllers;

class ErrorController
{
    public function index($errorMessage = null)
    {
        if (isset($_GET['message'])) {
            $errorMessage = $_GET['message'];
            require_once __DIR__ .'/../views/backend/errors/error.php';
        } else {
            $errorMessage = "Error message not provided.";
        }
    }
}
