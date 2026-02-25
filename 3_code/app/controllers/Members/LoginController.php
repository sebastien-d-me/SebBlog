<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;

class LoginController extends DefaultController {
    // Manages the queries
    function index(): void {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else if(isset($_GET["message"])) {
            $this->showMessage($_GET["message"]);
            return;
        } else {
            $_SESSION["csrf"] = bin2hex(random_bytes(32));
            $this->twigRender("pages/members/login.html.twig", [
                "csrf" => $_SESSION["csrf"]
            ]);
        }    
    }

    // Check the data values
    function check(array $data): void {
        foreach($data as $value) {
            if(empty($value)) {
                $this->showMessage("Some fields are not filled in.");
                return;
            }
        }

        $this->connect($data);
    }
    
    // Connect the member
    function connect(array $data): void {
        $usernameEmail = $data["login__username_email"];
        $password = $data["login__password"];

        if($data["csrf"] !== $_SESSION["csrf"]) {
            $this->showMessage("Error please retry.");
            return;
        }

        $checkLogin = LoginCredentials::where("username", $usernameEmail)->orWhere("email", $usernameEmail)->first();
        if(!$checkLogin) {
            $this->showMessage("Your username or your mail is incorrect.");
            return;
        }

        $checkPassword = password_verify($password, $checkLogin->getPassword());
        if(!$checkPassword) {
            $this->showMessage("Your password is incorrect.");
            return;
        }

        $memberId = Member::find($checkLogin->getIdLoginCredentials());
        $memberActive = $memberId->getIsActive();
        if($memberActive === 0) {
            $this->showMessage("Your account is not activated. Click <a class='link' href='/member/activation/send-activation'>here</a> to send an activation email.");
            return;
        }

        $_SESSION["member_id"] = $checkLogin->getIdLoginCredentials();
        $_SESSION["member_role"] = $memberId->getIdRole() === 1 ? "Administrator" : "Member";

        header("Location: /");
        return;
    }

    // Display the message
    function showMessage(string $message): void {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
        $this->twigRender("pages/members/login.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "message" => $message
        ]);
    }
}