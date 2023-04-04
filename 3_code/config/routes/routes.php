<?php 

// Define the routes
$routes = [
    /* Homepage */
    "/" => [
        "class" => "BaseController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Member | Register */
    "/member/register" => [
        "class" => "RegistrationController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    /* Member | Login */
    "/member/login" => [
        "class" => "LoginController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    /* Member | Logout */
    "/member/logout" => [
        "class" => "LogoutController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Member | Form to send activation */
    "/member/activation/send-activation" => [
        "class" => "AccountActivationController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ], 

    /* Member | Activate the account */
    "/member/activation/activate" => [
        "class" => "AccountActivationController",
        "method" => "activate",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    /* Member | Form to reset the password */
    "/member/password/password-reset" => [
        "class" => "PasswordResetController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    /* Member | Reset the password */
    "/member/password/reset" => [
        "class" => "PasswordResetController",
        "method" => "edit",
        "permissions" => [
            "Anonymous" => true,
            "Member" => false,
            "Administrator" => false
        ]
    ],

    /* Member | Profil */
    "/member/profil" => [
        "class" => "ProfilController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Member | Edit profil */
    "/member/profil/edit" => [
        "class" => "ProfilController",
        "method" => "edit",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Member | Delete account */
    "/member/profil/delete" => [
        "class" => "ProfilController",
        "method" => "delete",
        "permissions" => [
            "Anonymous" => false,
            "Member" => true,
            "Administrator" => false
        ]
    ],

    /* Error */
    "/error" => [
        "class" => "ErrorController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ]
];