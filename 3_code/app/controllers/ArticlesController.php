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

        $this->twigRender("pages/article.html.twig", [
            "article" => $article,
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
    
            $comment = new Comment();
            $comment->setContent($data["comment__content"]);
            $comment->setCreationDate(date("Y-m-d"));
            $comment->setIdMember($memberId);
            $comment->setIdCommentStatus(1);
            $comment->setIdArticle($articleId);
            $comment->save();
    
            $message = "Your comment has been submitted for validation.";
            header("Location: /articles/article?article=$articleId&message=$message");
        } else {
            $message = "You must write your comment.";
            header("Location: /articles/article?article=$articleId&message=$message");
        }
    }
}