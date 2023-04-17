<?php

/** Namespace */
namespace App\Controllers;

class DefaultController {
  /** Load parameters */
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
  
  /** Twig render */
  protected function twigRender($template, $data=[]) {
    $infosData = [
      "isLogged" => $this->isLogged,
      "role" => $this->role,
      "route" => $this->route
    ];
    echo $this->twig->render($template, array_merge($infosData, $data));
  }
}