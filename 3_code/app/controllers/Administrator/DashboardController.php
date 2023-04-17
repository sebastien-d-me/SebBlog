<?php

/** Namespace */
namespace App\Controllers;

/** Load */
use App\Controllers\DefaultController;

class DashboardController extends DefaultController {
  /** Show the dashboard */
  function index() {
    $this->twigRender("pages/administrator/dashboard.html.twig");
  }
}   