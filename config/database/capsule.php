<?php

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;

// Init it
$capsule = new Capsule;
$capsule->addConnection([
    "driver" => "mysql",
    "host" => "localhost",
    "port" => 3306,
    "database" => "sebblog",
    "username" => "root",
    "password" => "",
    "charset" => "utf8",
    "collation" => "utf8_unicode_ci",
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();