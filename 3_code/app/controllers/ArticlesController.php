<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;
use App\Models\Article;
use App\Models\Comment;
use App\Models\LoginCredentials;

class ArticlesController extends DefaultController {
    // Show the articles
    function index() {
        $articles = Article::all();

        $this->twigRender("pages/articles.html.twig", [
            "articles" => $articles
        ]);
    }

    // Show an article
    function showArticle() {
        $idArticle = $_GET["article"];
        $article = Article::where("idArticle", $idArticle)->first();
        $writer = LoginCredentials::find($article->idMember);
        $writer = $writer->getUsername();

        $comments = Comment::where("idArticle", $idArticle)->get();

        $commentsList = [];
        foreach($comments as $comment) {
            $user = LoginCredentials::find($comment->idMember);
            $user = $user->getUsername();

            $commentsList[] = [
                "comment" => $comment,
                "user" => $user
            ];
        }

        $this->twigRender("pages/article.html.twig", [
            "article" => $article,
            "commentsList" => $commentsList,
            "writer" => $writer
        ]);
    }
}