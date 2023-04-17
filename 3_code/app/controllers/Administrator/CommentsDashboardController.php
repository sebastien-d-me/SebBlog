<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;
use App\Models\Comment;
use App\Models\LoginCredentials;

class CommentsDashboardController extends DefaultController {
    // Show the dashboard
    function index(): void {
        $data = Comment::all();

        $message = "";
        if(isset($_GET["message"])) {
            $message = $_GET["message"];
        }

        $this->twigRender("pages/administrator/dashboard_comments.html.twig", [
            "datatable" => $data,
            "message" => $message
        ]);
    }

    // Validate the comment
    function validate(): void {
        $commentId = $_GET["comment"];
        $comment = Comment::where("idComment", $commentId)->first();
        $comment->setIdCommentStatus(1);
        $comment->save();

        $message = "The comment (ID : $commentId) has been validated.";
        header("Location: /admin/dashboard/comments?message=$message");
    }

    // Unvalidate the comment
    function unvalidate(): void {
        $commentId = $_GET["comment"];
        $comment = Comment::where("idComment", $commentId)->first();
        $comment->setIdCommentStatus(2);
        $comment->save();

        $message = "The comment (ID : $commentId) has been unvalidated.";
        header("Location: /admin/dashboard/comments?message=$message");
    }

    // Delete the comment
    function delete(): void {
        $commentId = $_GET["comment"];
        Comment::where("idComment", $commentId)->delete();

        $message = "The comment (ID : $commentId) has been deleted.";
        header("Location: /admin/dashboard/comments?message=$message");
    }
}   