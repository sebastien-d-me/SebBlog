<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class ErrorController extends DefaultController {
    // Display the error
    function index() {
        $errorCode = isset($_GET["code"]) ? $_GET["code"] : "Unknown";

        $this->twigRender("pages/error.html.twig", [
            "code" => $errorCode
        ]);
    }
}