<?php

// Constant for the database
define("DB_HOST", "localhost");
define("DB_NAME", "sebblog");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_CONNECTION", new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASSWORD));

// Load the twig files
$loader = new \Twig\Loader\FilesystemLoader("app/views");
$twig = new \Twig\Environment($loader);