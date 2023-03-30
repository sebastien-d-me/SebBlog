<?php

// Namespace
namespace App\Controllers;

class LogoutController extends DefaultController {
    // Disconnect the user
    function index() {
        unset($_SESSION["member_id"]);
        unset($_SESSION["member_reset"]);
        unset($_SESSION["member_role"]);
        session_destroy();

        header("Location: /member/login?message=You have been disconnected.");
        exit();
    }
}