<?php

class TestController {
    // Load Twig
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }

    // Functions of the controller
    function test() {
        $html = $this->twig->render("test.html.twig");
        return $html;
    }
}