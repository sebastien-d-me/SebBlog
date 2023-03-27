<?php

// Namespace
namespace App\Controllers;

class LogoutController extends DefaultController {
    // Disconnect the user
    function index() {
        session_start();

        unset($_SESSION["member_id"]);
        unset($_SESSION["member_role"]);
        session_destroy();

        header("Location: /");
        exit();
    }
}