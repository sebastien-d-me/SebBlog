<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class BaseController extends DefaultController {
    // Functions of the controller
    function index() {
        session_start();
        $isLogged = isset($_SESSION["idMember"]);
        $role = "";
        if(isset($_SESSION["roleMember"])) {
            $role = $_SESSION["roleMember"];
        }
        $html = $this->twig->render("pages/index.html.twig", [
            "isLogged" => $isLogged,
            "role" => $role,
            "route" => $this->route
        ]);
        echo $html;
    }
}