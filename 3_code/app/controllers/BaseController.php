<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class BaseController extends DefaultController {
    // Functions of the controller
    function index() {
        $this->twigRender("pages/index.html.twig");
    }
}