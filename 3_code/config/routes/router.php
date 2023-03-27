<?php

// Load the routes
require_once("routes.php");

// Get the current URL and check if the route exist
$currentURL = $_SERVER["REQUEST_URI"];
if(!array_key_exists($currentURL, $routes)) {
    header("Location: /");
    exit();
}

// Get the route and the settings
$route = $routes[$currentURL];

// Search the controller file and load it
$controllerFilePath = array_merge(
    glob("app/controllers/".$route["class"].".php"), 
    glob("app/controllers"."/**/".$route["class"].".php")
);
require_once($controllerFilePath[0]);

// Get the class and load it
$classPath = "App\Controllers\\".$route["class"];
$class = new $classPath($currentURL, $twig);

// Call the method of the class
if(array_key_exists("parameters", $route)) {
    echo $class->{$route["method"]}($route["parameters"]);
} else {
    echo $class->{$route["method"]}();
}

/// TODO
// Add a verification for the security