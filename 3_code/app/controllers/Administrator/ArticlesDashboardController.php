<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;
use App\Models\Article;
use App\Models\Comment;

class ArticlesDashboardController extends DefaultController {
    // Show the dashboard
    function index() {
        $data = Article::all();

        $message = "";
        if(isset($_GET["message"])) {
            $message = $_GET["message"];
        }

        $this->twigRender("pages/administrator/dashboard_articles.html.twig", [
            "datatable" => $data,
            "message" => $message
        ]);
    }

    // Unpublish the article
    function unpublish() {
        $articleId = $_GET["article"];
        $article = Article::where("idArticle", $articleId)->first();
        $article->setIdArticleStatus(2);
        $article->save();

        $message = "The article (ID : $articleId) has been unpublished.";
        header("Location: /admin/dashboard/articles?message=$message");
    }

    // Publish the article
    function publish() {
        $articleId = $_GET["article"];
        $article = Article::where("idArticle", $articleId)->first();
        $article->setIdArticleStatus(1);
        $article->save();

        $message = "The article (ID : $articleId) has been published.";
        header("Location: /admin/dashboard/articles?message=$message");
    }

    // Edit the article
    function edit() {

    }

    // Delete the article
    function delete() {
        $articleId = $_GET["article"];

        Comment::where("idArticle", $articleId)->delete();
        Article::where("idArticle", $articleId)->delete();

        $message = "The article (ID : $articleId) has been deleted.";
        header("Location: /admin/dashboard/articles?message=$message");
    }
}   