<?php

// Config the sessions
ini_set("session.cookie_lifetime", 3600);
ini_set("session.gc_maxlifetime", 86400);
session_set_cookie_params(86400);
session_start();


// Add the values to the sessions
$isLogged = isset($_SESSION["member_id"]);

if(isset($_SESSION["member_role"])) {
    switch($_SESSION["member_role"]) {
        case 1:
            $role = "Administrator";
            break;
        case 2:
            $role = "Member";
            break;
        default:
            $role = "Anonymous";
            break;
    }
} else {
    $role = "Anonymous";
}