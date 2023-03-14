<?php

// Load the routes
require_once("routes.php");

// Get the current URL
$currentURL = $_SERVER["REQUEST_URI"];

// Check if the route exist
if(!array_key_exists($currentURL, $routes)) {
    header("Location: /");
    exit;
}

// Decompose the route of the controller
$routeFound = explode("::", $routes[$currentURL]);

// Search the controller file
$controllerFilePath = array_merge(
    glob("app/controllers/".$routeFound[0].".php"), 
    glob("app/controllers"."/**/".$routeFound[0].".php")
);

// Load the controller file
$controllerFile = file_get_contents($controllerFilePath[0]);

// Get the namespace of the controller
$regex = "/namespace\s+([^\s;]+)/";
preg_match($regex, $controllerFile, $namespace);
$classPath = $namespace[1]."\\".$routeFound[0];

// Load and create an instance of the controller
$controller = new $classPath($twig);

// Call the function of the controller
echo $controller->{$routeFound[1]}();