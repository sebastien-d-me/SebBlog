<?php

// Namespace
namespace App\Controllers;

class DefaultController {
    // Load Twig
    protected $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
}