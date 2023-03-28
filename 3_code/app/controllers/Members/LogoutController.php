<?php

// Namespace
namespace App\Controllers;

class LogoutController extends DefaultController {
    // Disconnect the user
    function index() {
        session_destroy();

        header("Location: /");
        exit();
    }
}