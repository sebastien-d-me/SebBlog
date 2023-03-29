<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Hash;
use App\Models\Member;

class AccountActivationController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            isset($_POST["username"]) ? $this->saveAccountActivation($_POST) : $this->formAccountActivation($_POST);
        } else if(isset($_SESSION["member_activation"])) {
            $this->saveAccountActivation($_SESSION["member_activation"]);
        } else {
            if(isset($_GET["message"])) {
                $message = $_GET["message"];
                $this->twigRender("pages/members/activation.html.twig", [
                    "message" => $message
                ]);
            } else {
                $this->twigRender("pages/members/activation.html.twig");
            }
        }        
    }


    // Save the activation
    function saveAccountActivation($data) {
        $hash = new Hash();
        $hash->setHash($data["username"]);
        $hash->setIsActive(1);
        $hash->setIdMember($data["idMember"]);
        $hash->save();

        unset($_SESSION["member_activation"]);

        $this->sendAccountActivationMail($data["email"], $hash->getHash());
    }


    // Manage the form of the page
    function formAccountActivation($data) {
        $credentials = LoginCredentials::where("email", htmlspecialchars($data["activation__mail"], ENT_QUOTES))->first();
        if($credentials === NULL) {
            $message = "No account exists with this email address.";
            $this->showAccountActivationError($message);
            exit();
        }

        $member = Member::where("idMember", $credentials->getIdMember())->first();
        if($member->getIsActive() === 1) {
            $message = "Your account is already activated.";
            $this->showAccountActivationError($message);
            exit();
        }

        $hash = Hash::where("idMember", $credentials->getIdMember())->first();

        $this->sendAccountActivationMail($credentials->getEmail(), $hash->getHash());
    }


    // Send the activation mail
    function sendAccountActivationMail($recipient, $hash) {
        $mailURL = "https://$_SERVER[HTTP_HOST]/member/activation/activate?code=$hash";
        $mailContent = "Click here to activate your account : $mailURL";

        $mailValues = [
            "to" => $recipient,
            "subject" => "SebBlog - Account activation",
            "content" => $mailContent
        ];
        sendMail($mailValues);

        $message = "An email to activate your account has been sent to you.";
        header("Location: /member/login?message=$message");
        exit();
    }


    // Activate the account
    function activateAccount() {
        $hash = $_GET["code"];
        $hash = Hash::where("hash", $hash)->first();

        if($hash === NULL || $hash === 0) {
            $message = "Your code not work, please retry later.";
            $this->showAccountActivationError($message);
            exit();
        }

        $member = Member::where("idMember", $hash->getIdMember())->first();

        if($member->getIsActive() === 0) {
            $hash->setIsActive(0);
            $member->setIsActive(true);
            $member->save();
            $message = "Your account has been activated.";
        } else {
            $message = "Your account is already activated.";
        }

        header("Location: /member/login?message=$message");
        exit();
    }


    // Display the errors
    function showAccountActivationError($message) {
        $this->twigRender("pages/members/activation.html.twig", [
            "message" => $message
        ]);
    }
}