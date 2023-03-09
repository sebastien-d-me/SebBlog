<?php

class HomeController {
    // Load Twig
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }

    // Functions of the controller
    function index() {
        $html = $this->twig->render("base.html.twig");
        return $html;
    }
}