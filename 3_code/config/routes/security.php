<?php

// Config the sessions
ini_set("session.cookie_lifetime", 3600);
ini_set("session.gc_maxlifetime", 86400);
session_set_cookie_params(86400);
session_start();

// Add the values to the sessions
$isLogged = isset($_SESSION["idMember"]);
if(isset($_SESSION["roleMember"])) {
    switch($_SESSION["roleMember"]) {
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