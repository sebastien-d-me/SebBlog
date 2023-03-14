<?php

// Namespace
namespace App\Controllers;

// Load model
use App\Models\Test;

class TestController {
    // Load Twig
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }

    // Functions of the controller
    function update() {
        $test = new Test();
        $SQL = $test->update(1, "Sébastien D.");
        $html = $this->twig->render("base.html.twig", ["statut" => "Updated"]);
        return $html;
    }
}