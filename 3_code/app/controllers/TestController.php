<?php

// Load the model
require_once("app/models/Test.php");

class TestController {
    // Load Twig
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }

    // Functions of the controller
    function test() {
        $test = new Test();
        $values = $test->getTests();
        $html = $this->twig->render("test.html.twig", ["test" => $values]);
        return $html;
    }
}