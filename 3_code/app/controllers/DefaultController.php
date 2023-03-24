<?php

// Namespace
namespace App\Controllers;

class DefaultController {
    // Load parameters
    protected $route;
    protected $twig;
    
    public function __construct($route, $twig) {
        $this->route = $route;
        $this->twig = $twig;
    }
}