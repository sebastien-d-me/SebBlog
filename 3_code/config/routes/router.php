<?php

// Load the routes
require_once("routes.php");

// Get the current URL and 
$currentURL = $_SERVER["REQUEST_URI"];

// Decompose the route of the controller
$routeFound = explode("::", $routes[$currentURL]);

// Load and create an instance of the controller
require_once("app/controllers/${routeFound[0]}.php");
$controller = new $routeFound[0]($twig);

// Call the function of the controller
echo $controller->{$routeFound[1]}();