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
            $this->checkLoginFields($_POST);
        } else {
            $this->twigRender("pages/members/login.html.twig");
        }        
    }


    // Check the fields
    function checkLoginFields($fields) {
        $correctFields = true;
        foreach($fields as $field) {
            $field === "" ? $correctFields = false : $correctFields = true;
        }

        $correctFields ? $this->connectLogin($fields) : $this->showConnectionError("You must fill in all the fields.");
    }

    
    // Do the connection
    function connectLogin($fields) {
        $login = $fields["login__username_mail"];
        $password = $fields["login__password"];

        $checkLogin = LoginCredentials::where("username", $login)->orWhere("email", $login)->first();
        if(!$checkLogin) {
            $message = "Your username or your mail is incorrect.";
            $this->showConnectionError($message);
            exit();
        }

        $checkPassword = password_verify($password, $checkLogin->getPassword());
        if(!$checkPassword) {
            $message = "Your password is incorrect.";
            $this->showConnectionError($message);
            exit();
        }

        $memberId = Member::find($checkLogin->getIdLoginCredentials());
        $memberActive = $memberId->getIsActive();
        if($memberActive === 0) {
            $message = "Your account is not activated. Click <a class='link' href='/send-activation'>here</a> to send an activation email.";
            $this->showConnectionError($message);
            exit();
        }

        $roleMember = $memberId->getIdRole();
        $_SESSION["member_id"] = $checkLogin->getIdLoginCredentials();
        $_SESSION["member_role"] = ($roleMember === 1) ? "Administrator" : "Member";

        header("Location: /");
        exit();
    }
    

    // Display the errors
    function showConnectionError($message) {
        $this->twigRender("pages/members/login.html.twig", [
            "message" => $message
        ]);
    }
}