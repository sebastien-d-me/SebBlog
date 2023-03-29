<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;

class LoginController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->checkFields($_POST);
        } else {
            if(isset($_GET["message"])) {
                $message = $_GET["message"];
                $this->twigRender("pages/members/login.html.twig", [
                    "message" => $message
                ]);
            } else {
                $this->twigRender("pages/members/login.html.twig");
            }
        }        
    }


    // Check the fields
    function checkFields($fields) {
        $correctFields = true;
        foreach($fields as $field) {
            $field === "" ? $correctFields = false : $correctFields = true;
        }

        $correctFields ? $this->connect($fields) : $this->showError("You must fill in all the fields.");
    }

    
    // Do the connection
    function connect($fields) {
        $login = htmlspecialchars($fields["login__username_mail"], ENT_QUOTES);
        $password = htmlspecialchars($fields["login__password"], ENT_QUOTES);

        $checkLogin = LoginCredentials::where("username", $login)->orWhere("email", $login)->first();
        if(!$checkLogin) {
            $message = "Your username or your mail is incorrect.";
            $this->showError($message);
            exit();
        }

        $checkPassword = password_verify($password, $checkLogin->getPassword());
        if(!$checkPassword) {
            $message = "Your password is incorrect.";
            $this->showError($message);
            exit();
        }

        $memberId = Member::find($checkLogin->getIdLoginCredentials());
        $memberActive = $memberId->getIsActive();
        if($memberActive === 0) {
            $message = "Your account is not activated. Click <a class='link' href='/member/activation/send-activation'>here</a> to send an activation email.";
            $this->showError($message);
            exit();
        }

        $roleMember = $memberId->getIdRole();
        $_SESSION["member_id"] = $checkLogin->getIdLoginCredentials();
        $_SESSION["member_role"] = ($roleMember === 1) ? "Administrator" : "Member";

        header("Location: /");
        exit();
    }
    

    // Display the errors
    function showError($message) {
        $this->twigRender("pages/members/login.html.twig", [
            "message" => $message
        ]);
    }
}