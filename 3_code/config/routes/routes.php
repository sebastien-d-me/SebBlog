<?php 

// Define the routes
$routes = [
    /* Homepage */
    "/" => [
        "class" => "HomeController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Articles */
    "/articles" => [
        "class" => "ArticlesController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => true
        ]
    ],

    /* Articles | Article */
    "/articles/article" => [
        "class" => "ArticlesController",
        "method" => "showArticle",
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
            "Anonymous" => true,
            "Member" => true,
            "Administrator" => false
        ]
    ],

    /* Dashboard */
    "/admin/dashboard" => [
        "class" => "DashboardController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Members dashboard */
    "/admin/dashboard/members" => [
        "class" => "MembersDashboardController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Members dashboard - Desactivate */
    "/admin/dashboard/members/desactivate" => [
        "class" => "MembersDashboardController",
        "method" => "desactivate",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Members dashboard - Activate */
    "/admin/dashboard/members/activate" => [
        "class" => "MembersDashboardController",
        "method" => "activate",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Members dashboard - Delete */
    "/admin/dashboard/members/delete" => [
        "class" => "MembersDashboardController",
        "method" => "delete",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],
    
    /* Dashboard | Articles dashboard */
    "/admin/dashboard/articles" => [
        "class" => "ArticlesDashboardController",
        "method" => "index",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Articles dashboard - Create */
    "/admin/dashboard/articles/create" => [
        "class" => "ArticlesDashboardController",
        "method" => "create",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Articles dashboard - Unpublish */
    "/admin/dashboard/articles/unpublish" => [
        "class" => "ArticlesDashboardController",
        "method" => "unpublish",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Articles dashboard - Publish */
    "/admin/dashboard/articles/publish" => [
        "class" => "ArticlesDashboardController",
        "method" => "publish",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Articles dashboard - Edit */
    "/admin/dashboard/articles/edit" => [
        "class" => "ArticlesDashboardController",
        "method" => "edit",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
        ]
    ],

    /* Dashboard | Articles dashboard - Delete */
    "/admin/dashboard/articles/delete" => [
        "class" => "ArticlesDashboardController",
        "method" => "delete",
        "permissions" => [
            "Anonymous" => false,
            "Member" => false,
            "Administrator" => true
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