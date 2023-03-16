<?php

// Load the routes
require_once("routes.php");

// Get the current URL
$currentURL = $_SERVER["REQUEST_URI"];

// Check ID
$checkID = is_numeric(substr($currentURL, strrpos($currentURL, "/") + 1));
if($checkID === true) {
    $id = substr($currentURL, strrpos($currentURL, "/") + 1);
    $currentURL = dirname($currentURL)."/{id}";
}

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
$regexNamespace = "/namespace\s+([^\s;]+)/";
preg_match($regexNamespace, $controllerFile, $namespace);
$classPath = $namespace[1]."\\".$routeFound[0];

// Load and create an instance of the controller
$controller = new $classPath($twig);

// Call the function of the controller
if($checkID === true) {
    echo $controller->{$routeFound[1]}($id);
} else {
    echo $controller->{$routeFound[1]}();
}
