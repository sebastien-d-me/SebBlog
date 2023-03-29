<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class PasswordResetController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->handleForm($_POST);
        } else {
            $this->twigRender("pages/members/password_reset.html.twig"); 
        }
    }


    // Manage the form of the page
    function handleForm($data) {
        $login = htmlspecialchars($data["password_reset__username_mail"], ENT_QUOTES);

        $credentials = LoginCredentials::where("username", $login)->orWhere("email", $login)->first();
        if($credentials === NULL) {
            $message = "No account exists with this email address.";
            $this->showError($message);
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
        $passwordReset = new Hash();
        $passwordReset->setHash($data["username"]);
        $passwordReset->setIsActive(1);
        $passwordReset->setIdMember($data["idMember"]);
        $passwordReset->save();

        $_SESSION["member_reset"] = $data;

        $this->sendMail($passwordReset->getHash(), $data["email"]);
    }


    // Send the password reset mail
    function sendMail($hash, $recipient) {
        $mailURL = "https://$_SERVER[HTTP_HOST]/member/password/reset?code=$hash";
        $mailContent = "Click here to reset your password : $mailURL";

        $mailValues = [
            "to" => $recipient,
            "subject" => "SebBlog - Password reset",
            "content" => $mailContent
        ];
        sendMail($mailValues);

        $message = "An email to reset your password has been sent to you.";
        header("Location: /member/login?message=$message");
        exit();
    }


    // Show the edit form
    function edit() {
        if(!isset($_SESSION["member_reset"])) {
            $message = "Try to reset your password again.";
            $this->showError($message);
            exit();
        }

        if(!empty($_POST)) {
            $credentials = LoginCredentials::where("username", $_SESSION["member_reset"])->orWhere("email", $_SESSION["member_reset"])->first();
            $credentials->setPassword(htmlspecialchars($_POST["password_reset__password"], ENT_QUOTES));
            $credentials->save();

            $hash = $_GET["code"];
            $hash = Hash::where("hash", $hash)->first();
            $hash->setIsActive(0);
            $hash->save();
            
            unset($_SESSION["member_reset"]);

            $message = "Your new password has been saved.";
            header("Location: /member/login?message=$message");
        }

        $this->twigRender("pages/members/password_reset-edit.html.twig");
    }


    // Display the errors
    function showError($message) {
        $this->twigRender("pages/members/password_reset.html.twig", [
            "message" => $message
        ]);
    }
}