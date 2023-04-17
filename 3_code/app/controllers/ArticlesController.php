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
        $articles = Article::where("idArticleStatus", 1)->get();

        $this->twigRender("pages/articles.html.twig", [
            "articles" => $articles
        ]);
    }

    // Show an article
    function showArticle() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->saveComment($_POST);
            exit();
        }

        $message = "";
        if(isset($_GET["message"])) {
            $message = $_GET["message"];
        }

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

        $_SESSION["csrf"] = bin2hex(random_bytes(32));

        $this->twigRender("pages/article.html.twig", [
            "article" => $article,
            "csrf" => $_SESSION["csrf"],
            "commentsList" => $commentsList,
            "message" => $message,
            "writer" => $writer
        ]);
    }

    // Save the comment
    function saveComment($data) {
        $articleId = $_GET["article"];
        if(!empty($data["comment__content"])) {
            $memberId = $_SESSION["member_id"];

            if($data["csrf"] !== $_SESSION["csrf"]) {
                $message = "Error please retry.";
                header("Location: /articles/article?article=$articleId&message=$message");
                exit();
            }
    
            $comment = new Comment();
            $comment->setContent(htmlspecialchars($data["comment__content"], ENT_QUOTES));
            $comment->setCreationDate(date("Y-m-d"));
            $comment->setIdMember(htmlspecialchars($memberId, ENT_QUOTES));
            $comment->setIdCommentStatus(1);
            $comment->setIdArticle(htmlspecialchars($articleId, ENT_QUOTES));
            $comment->save();
    
            $message = "Your comment has been submitted for validation.";
            header("Location: /articles/article?article=$articleId&message=$message");
        } else {
            $message = "You must write your comment.";
            header("Location: /articles/article?article=$articleId&message=$message");
        }
    }
}