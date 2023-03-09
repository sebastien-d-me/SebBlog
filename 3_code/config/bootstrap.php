<?php

// Bootstrap Twig
$loader = new \Twig\Loader\FilesystemLoader("app/views");
$twig = new \Twig\Environment($loader);