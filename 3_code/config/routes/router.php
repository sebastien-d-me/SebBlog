<?php

// Load the routes
require_once("routes.php");


// Get the current URL and check if the route exist
$currentURL = $_SERVER["REQUEST_URI"];
$currentURL = strstr($currentURL, "?", true) ? : $currentURL;
/*if(!array_key_exists($currentURL, $routes)) {
    header("Location: /error?code=404");
    exit();
}*/


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
$class = new $classPath($isLogged, $role, $currentURL, $twig);


// Get the permissions
if(!isset($_SESSION["member_role"])) {
    $currentRole = "Anonymous";
} else {
    $currentRole = $_SESSION["member_role"];
}

if($route["permissions"][$currentRole] !== true) {
    header("Location: /error?code=401");
    exit();
}


// Call the method of the class
if(array_key_exists("parameters", $route)) {
    echo $class->{$route["method"]}($route["parameters"]);
} else {
    echo $class->{$route["method"]}();
}