<?php

// Namespace
namespace App\Controllers;

class DefaultController {
    // Load parameters
    protected $isLogged;
    protected $role;
    protected $route;
    protected $twig;
    
    public function __construct($isLogged, $role, $route, $twig) {
        $this->isLogged = $isLogged;
        $this->role = $role;
        $this->route = $route;
        $this->twig = $twig;
    }
}