<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class ErrorController extends DefaultController {
    // Unauthorized error

    function error401() {
        $html = $this->twig->render("pages/error.html.twig", [
            "code" => 401,
            "message" => "You do not have access to this page.",
            "isLogged" => $this->isLogged,
            "role" => $this->role,
            "route" => $this->route
        ]);
        echo $html;
    }
}