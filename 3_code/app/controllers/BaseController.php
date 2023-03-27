<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class BaseController extends DefaultController {
    // Functions of the controller
    function index() {
        $html = $this->twig->render("pages/index.html.twig", [
            "isLogged" => $this->isLogged,
            "role" => $this->role,
            "route" => $this->route
        ]);
        echo $html;
    }
}