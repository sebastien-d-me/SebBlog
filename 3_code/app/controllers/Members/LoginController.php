<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;

class LoginController extends DefaultController {
    // Manages the queries
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else if(isset($_GET["message"])) {
            $this->showMessage($_GET["message"]);
            exit();
        } else {
            $_SESSION["csrf"] = bin2hex(random_bytes(32));
            $this->twigRender("pages/members/login.html.twig", [
                "csrf" => $_SESSION["csrf"]
            ]);
        }    
    }

    // Check the data values
    function check($data) {
        foreach($data as $value) {
            if(empty($value)) {
                $this->showMessage("Some fields are not filled in.");
                exit();
            }
        }

        $this->connect($data);
    }
    
    // Connect the member
    function connect($data) {
        $usernameEmail = $data["login__username_email"];
        $password = $data["login__password"];

        if($data["csrf"] !== $_SESSION["csrf"]) {
            $this->showMessage("Error please retry.");
            exit();
        }

        $checkLogin = LoginCredentials::where("username", $usernameEmail)->orWhere("email", $usernameEmail)->first();
        if(!$checkLogin) {
            $this->showMessage("Your username or your mail is incorrect.");
            exit();
        }

        $checkPassword = password_verify($password, $checkLogin->getPassword());
        if(!$checkPassword) {
            $this->showMessage("Your password is incorrect.");
            exit();
        }

        $memberId = Member::find($checkLogin->getIdLoginCredentials());
        $memberActive = $memberId->getIsActive();
        if($memberActive === 0) {
            $this->showMessage("Your account is not activated. Click <a class='link' href='/member/activation/send-activation'>here</a> to send an activation email.");
            exit();
        }

        $_SESSION["member_id"] = $checkLogin->getIdLoginCredentials();
        $_SESSION["member_role"] = $memberId->getIdRole() === 1 ? "Administrator" : "Member";

        header("Location: /");
        exit();
    }

    // Display the message
    function showMessage($message) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
        $this->twigRender("pages/members/login.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "message" => $message
        ]);
    }
}