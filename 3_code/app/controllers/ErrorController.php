<?php

/** Namespace */
namespace App\Controllers;

/** Load */
use App\Controllers\DefaultController;

class ErrorController extends DefaultController {
  /** Display the error */
  function index() {
    if(isset($_GET["code"])) {
      $errorCode = $_GET["code"];
    } else {
      $errorCode = "Unknown";
    }

    $this->twigRender("pages/error.html.twig", [
      "code" => $errorCode
    ]);
  }
}