<?php

// Namespace
namespace App\Controllers;

class LogoutController extends DefaultController {
    // Disconnect the user
    function index() {
        session_start();

        unset($_SESSION["idMember"]);
        unset($_SESSION["roleMember"]);
        session_destroy();

        header("Location: /");
        exit();
    }
}