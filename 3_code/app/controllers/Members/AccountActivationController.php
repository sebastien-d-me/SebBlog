<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class AccountActivationController extends DefaultController {
    // Manages the the queries
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else if(isset($_GET["message"])) {
            $this->showMessage($_GET["message"]);
            exit();
        } else {
            $this->twigRender("pages/members/activation.html.twig");
        }
    }        

    // Check the data values
    function check($data) {
        $email = $data["activation__email"];

        $credentials = LoginCredentials::where("email", htmlspecialchars($email, ENT_QUOTES))->first();
        if($credentials === NULL) {
            $this->showError("No account exists with this email address.");
            exit();
        }

        $member = Member::where("idMember", $credentials->getIdMember())->first();
        $hash = Hash::where("idMember", $credentials->getIdMember())->first();
        if($member->getIsActive() === 1) {
            $this->showError("Your account is already activated.");
            exit();
        }

        $getHash = $hash->getHash();
        $mailValues = [
            "to" => $loginCredentials->getEmail(),
            "subject" => "Account activation",
            "content_message" => "Click here to activate your account",
            "content_route" => "/member/activation/activate",
            "content_hash" => "?code=$getHash",
            "header_route" => "/member/login",
            "header_message" => "An email to activate your account has been sent to you."
        ];
        sendMail($mailValues);
    }

    // Activate the account
    function activate() {
        $hash = Hash::where("hash", $_GET["code"])->first();

        if($hash === NULL) {
            $this->showError("Your code not work, please retry later.");
            exit();
        }

        $member = Member::where("idMember", $hash->getIdMember())->first();

        if($member->getIsActive() === 0) {
            $hash->setIsActive(0);
            $hash->save();
            $member->setIsActive(true);
            $member->save();
            $message = "Your account has been activated.";
        } else {
            $message = "Your account is already activated.";
        }

        header("Location: /member/login?message=$message");
        exit();
    }

    // Display the message
    function showMessage($message) {
        $this->twigRender("pages/members/activation.html.twig", [
            "message" => $message
        ]);
    }
}