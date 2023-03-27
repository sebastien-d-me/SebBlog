<?php 

// Load the security
require_once("security.php");

// Define the routes with the controller
$routes = [
    "/" => [
        "class" => "BaseController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Errors */
    "/401" => [
        "class" => "ErrorController",
        "method" => "error401",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Members */
    "/register" => [
        "class" => "RegistrationController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/activate" => [
        "class" => "RegistrationController",
        "method" => "activateAccount",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],    

    "/login" => [
        "class" => "LoginController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/logout" => [
        "class" => "LogoutController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => true
        ]
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
    "permissions" => [
        "Anonymous" => true,
        "Member" => true,
        "Administrator" => true
    ]
]
*/