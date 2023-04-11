<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;
use App\Models\Article;
use App\Models\LoginCredentials;

class ArticlesController extends DefaultController {
    // Show the articles
    function index() {
        $articles = Article::all();
        $usernames = [];

        foreach($articles as $article) {
            $username = LoginCredentials::find($article->idMember);
            $username = $username->getUsername();

            $articlesList[] = [
                "article" => $article,
                "username" => $username
            ];
        }

        $this->twigRender("pages/articles.html.twig", [
            "articlesList" => $articlesList
        ]);
    }

    // Show an article
    function showArticle() {
        $idArticle = $_GET["article"];
        $article = Article::where("idArticle", $idArticle)->first();
        $username = LoginCredentials::find($article->idMember);
        $username = $username->getUsername();

        $this->twigRender("pages/article.html.twig", [
            "article" => $article,
            "username" => $username
        ]);
    }
}