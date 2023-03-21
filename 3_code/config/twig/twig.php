<?php

// Create the variable
$loader = new \Twig\Loader\FilesystemLoader("app/views");
$twig = new \Twig\Environment($loader);

require_once("twigGlobal.php");