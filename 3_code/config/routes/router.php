<?php

/** Load the security */
require_once("security.php");

/** Load the routes */
require_once("routes.php");

/** Get the current path and check if the route exist */
$currentURL = strtok($_SERVER["REQUEST_URI"], "?");
if(!array_key_exists($currentURL, $routes)) {
  header("Location: /error?code=404");
}

/** Get the route informations */
$route = $routes[$currentURL];

/** Search the controller file and load it */
$controllerFilePath = array_merge(
  glob("app/controllers/".$route["class"].".php"), 
  glob("app/controllers"."/**/".$route["class"].".php")
);
require_once($controllerFilePath[0]);

/** Get the class and init it */
$classPath = "App\Controllers\\".$route["class"];
$class = new $classPath($isLogged, $role, $currentURL, $twig);

/** Get the user permissions */
if($route["permissions"][$role] === false) {
  header("Location: /error?code=401");
}

/** Call the method of the class */
echo array_key_exists("parameters", $route) ? $class->{$route["method"]}($route["parameters"]) : $class->{$route["method"]}();