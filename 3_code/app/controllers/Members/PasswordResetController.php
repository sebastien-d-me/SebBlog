<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class PasswordResetController extends DefaultController {
    // Manages the queries
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else {
            $this->twigRender("pages/members/password/password_reset.html.twig"); 
        }
    }

    // Check the data values
    function check($data) {
        $usernameEmail = htmlspecialchars($data["password_reset__username_email"], ENT_QUOTES);

        $credentials = LoginCredentials::where("username", $usernameEmail)->orWhere("email", $usernameEmail)->first();
        if($credentials === NULL) {
            $this->showError("No account exists with this email address.");
            exit();
        }

        $data = [
            "username" => $credentials->getUsername(),
            "email" => $credentials->getEmail(),
            "idMember" => $credentials->getIdMember()
        ];

        $this->saveHash($data);        
    }

    // Save the hash
    function saveHash($data) {
        $username = $data["username"];
        $email = $data["email"];
        $idMember = $data["idMember"];

        $hash = new Hash();
        $hash->setHash($username);
        $hash->setIsActive(1);
        $hash->setIdMember($idMember);
        $hash->save();

        $_SESSION["member_reset"] = $data;

        $getHash = $hash->getHash();
        $mailValues = [
            "to" => $loginCredentials->getEmail(),
            "subject" => "Password reset",
            "content_message" => "Click here to reset your password",
            "content_route" => "/member/password/reset",
            "content_hash" => "?code=$getHash",
            "header_route" => "/member/login",
            "header_message" => "An email to reset your password has been sent to you."
        ];
        sendMail($mailValues);
    }

    // Show the edit form
    function edit() {
        if(!isset($_SESSION["member_reset"])) {
            header("Location: /member/password/password-reset");
            exit();
        }

        if(!empty($_POST)) {
            $memberReset = $_SESSION["member_reset"];
            $passwordReset = $_POST["password_reset__password"];

            $credentials = LoginCredentials::where("username", $memberReset)->orWhere("email", $memberReset)->first();
            $credentials->setPassword(htmlspecialchars($passwordReset, ENT_QUOTES));
            $credentials->save();

            $hash = Hash::where("hash", $_GET["code"])->first();
            $hash->setIsActive(0);
            $hash->save();
            
            unset($_SESSION["member_reset"]);

            $message = "Your new password has been saved.";
            header("Location: /member/login?message=$message");
        }

        $this->twigRender("pages/members/password/password_reset-edit.html.twig");
    }

    // Display the message
    function showMessage($message) {
        $this->twigRender("pages/members/password/password_reset.html.twig", [
            "message" => $message
        ]);
    }
}