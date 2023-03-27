<?php

// Namespace
namespace App\Controllers;

class LogoutController extends DefaultController {
    // Functions of the controller
    function index() {
        session_start();
        unset($_SESSION["idMember"]);
        unset($_SESSION["roleMember"]);
        session_destroy();
        header("Location: /");
        exit();
    }
}