<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use Exception;

class ErrorController extends Controller
{
    public function index($errorMessage = null)
    {
        try {
            return View::make('errors.500');
        } catch (Exception $e) {
            return $this->error($e);
        }
    }
}
