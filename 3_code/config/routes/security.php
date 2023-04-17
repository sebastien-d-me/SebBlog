<?php

// Config the session
ini_set("session.cookie_lifetime", 3600);
ini_set("session.gc_maxlifetime", 86400);
session_set_cookie_params(86400);
session_start();

// Manage the error
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error) {
        header("Location: /error?code=500");
        exit();
    }
});

// Check if logged
$isLogged = isset($_SESSION["member_id"]);

// Init the role
isset($_SESSION["member_role"]) ? $role = $_SESSION["member_role"] : $role = "Anonymous";