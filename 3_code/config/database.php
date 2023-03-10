<?php

// Constant for the database
define("DB_HOST", "localhost");
define("DB_NAME", "sebblog");
define("DB_USER", "root");
define("DB_PASSWORD", "");

// PDO
$databasePDO = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASSWORD);