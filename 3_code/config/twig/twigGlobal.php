<?php

/** Load model
use App\Models\Article;

/** Load random articles
$randArticles = Article::inRandomOrder()->take(3)->get();
$twig->addGlobal("randArticles", $randArticles);