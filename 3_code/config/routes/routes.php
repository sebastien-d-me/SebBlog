<?php 

// Load the security
require_once("security.php");

// Define the routes with the controller
$routes = [
    "/" => [
        "class" => "BaseController",
        "method" => "index",
        "security_level" => $securityLevel[0]
    ]
];


// Example
/*
"/" => [
    "class" => "BaseController",
    "method" => "index",
    "parameters" => [
        "id" => 1
    ],
    "security_level" => $securityLevel[0]
]
*/