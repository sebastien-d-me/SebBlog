<?php

// Namespace
namespace App\Controllers;

class DefaultController {
    // Load parameters
    protected $isLogged;
    protected $role;
    protected $route;
    protected $twig;
    
    public function __construct(bool $isLogged, string $role, string $route, object $twig) {
        $this->isLogged = $isLogged;
        $this->role = $role;
        $this->route = $route;
        $this->twig = $twig;
    }
    
    // Twig render
    protected function twigRender(string $template, array $data = []): void {
        $infosData = [
            "isLogged" => $this->isLogged,
            "role" => $this->role,
            "route" => $this->route
        ];
        echo $this->twig->render($template, array_merge($infosData, $data));
    }
}