<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class LegalNoticeController extends DefaultController {
    // Show the page
    function index() {
        $this->twigRender("pages/legal-notice.html.twig");
    }
}   