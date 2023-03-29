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
    "/error" => [
        "class" => "ErrorController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],


    /* Members */
    "/member/register" => [
        "class" => "RegistrationController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/member/login" => [
        "class" => "LoginController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/member/logout" => [
        "class" => "LogoutController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    "/member/activation/send-activation" => [
        "class" => "ActivationController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ], 

    "/member/activation/activate" => [
        "class" => "ActivationController",
        "method" => "activateAccount",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
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