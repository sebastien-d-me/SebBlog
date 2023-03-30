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
        "class" => "AccountActivationController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ], 

    "/member/activation/activate" => [
        "class" => "AccountActivationController",
        "method" => "activate",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/member/password/password-reset" => [
        "class" => "PasswordResetController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/member/password/reset" => [
        "class" => "PasswordResetController",
        "method" => "edit",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    "/member/profil" => [
        "class" => "ProfilController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    "/member/profil/edit" => [
        "class" => "ProfilController",
        "method" => "edit",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    "/member/profil/delete" => [
        "class" => "ProfilController",
        "method" => "delete",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => false
        ]
    ]
];


// Example
/*
"/" => [
    "class" => "BaseController",
    "method" => "index",
    "permissions" => [
        "Anonymous" => true,
        "Member" => true,
        "Administrator" => true
    ]
]
*/