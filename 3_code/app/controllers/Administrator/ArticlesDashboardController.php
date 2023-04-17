<?php

/** Namespace */
namespace App\Controllers;

/** Load */
use App\Controllers\DefaultController;
use App\Models\Article;
use App\Models\Comment;
use App\Models\LoginCredentials;
use App\Models\Member;

class ArticlesDashboardController extends DefaultController {
    /** Show the dashboard */
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

    /** Unpublish the article */
    function unpublish() {
        $articleId = $_GET["article"];
        $article = Article::where("idArticle", $articleId)->first();
        $article->setIdArticleStatus(2);
        $article->save();

        $message = "The article (ID : $articleId) has been unpublished.";
        header("Location: /admin/dashboard/articles?message=$message");
    }

    /** Publish the article */
    function publish() {
        $articleId = $_GET["article"];
        $article = Article::where("idArticle", $articleId)->first();
        $article->setIdArticleStatus(1);
        $article->save();

        $message = "The article (ID : $articleId) has been published.";
        header("Location: /admin/dashboard/articles?message=$message");
    }

    /** Create an article */
    function create() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->save("new", $_POST);
        }

        $administrators = Member::join("logincredentials", "member.idLoginCredentials", "=", "logincredentials.idLoginCredentials");
        $administrators = $administrators->where("member.idRole", 1);
        $administrators = $administrators->select("logincredentials.username", "member.idMember");
        $administrators = $administrators->get();

        $message = "";

        $this->twigRender("pages/administrator/dashboard_articles_form.html.twig", [
            "administrators" => $administrators,
            "message" => $message
        ]);
    }

    /** Edit the article */
    function edit() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->save("edit", $_POST);
        }

        $articleId = $_GET["article"];
        $data = Article::where("idArticle", $articleId)->first();

        $administrators = Member::join("logincredentials", "member.idLoginCredentials", "=", "logincredentials.idLoginCredentials");
        $administrators = $administrators->where("member.idRole", 1);
        $administrators = $administrators->select("logincredentials.username", "member.idMember");
        $administrators = $administrators->get();

        $message = "";

        $this->twigRender("pages/administrator/dashboard_articles_form.html.twig", [
            "administrators" => $administrators,
            "data" => $data,
            "message" => $message
        ]);
    }

    /** Save the article */
    function save($type, $data) {
        $data["article__status"] === "published" ? $idArticleStatus = 1 : $idArticleStatus = 2;

        if($type === "new") {
            $article = new Article();
            $article->setCreationDate(date("Y-m-d"));
        } else {
            $articleId = $_GET["article"];
            $article = Article::where("idArticle", $articleId)->first();
        }

        $article->setTitle($data["article__title"]);
        $article->setUpdateDate(date("Y-m-d"));
        $article->setSummary($data["article__summary"]);
        $article->setContent($data["article__content"]);
        $article->setIdArticleStatus($idArticleStatus);
        $article->setIdMember($data["article__author"]);
        $article->save();

        $articleId = $article->getIdArticle();

        $message = "The article (ID : $articleId) has been created / updated.";
        header("Location: /admin/dashboard/articles?message=$message");
    }

    /** Delete the article */
    function delete() {
        $articleId = $_GET["article"];

        Comment::where("idArticle", $articleId)->delete();
        Article::where("idArticle", $articleId)->delete();

        $message = "The article (ID : $articleId) has been deleted.";
        header("Location: /admin/dashboard/articles?message=$message");
    }
}   