<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;
use App\Models\Activation;

class ActivationController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            isset($_POST["username"]) ? $this->saveActivation($_POST) : $this->formActivation($_POST);
        } else if(isset($_SESSION["member_activation"])) {
            $this->saveActivation($_SESSION["member_activation"]);
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
    function saveActivation($data) {
        $activation = new Activation();
        $activation->setHash($data["username"]);
        $activation->setIdMember($data["idMember"]);
        $activation->save();

        unset($_SESSION["member_activation"]);

        $this->sendActivationMail($data["email"], $activation->getHash());
    }


    // Manage the form of the page
    function formActivation($data) {
        $credentials = LoginCredentials::where("email", htmlspecialchars($data["activation_mail"], ENT_QUOTES))->first();
        if($credentials === NULL) {
            $message = "No account exists with this email address.";
            $this->showActivationError($message);
            exit();
        }

        $member = Member::where("idMember", $credentials->getIdMember())->first();
        if($member->getIsActive() === 1) {
            $message = "Your account is already activated.";
            $this->showActivationError($message);
            exit();
        }

        $activation = Activation::where("idMember", $credentials->getIdMember())->first();

        $this->sendActivationMail($credentials->getEmail(), $activation->getHash());
    }


    // Send the activation mail
    function sendActivationMail($recipient, $hash) {
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
        $activation = Activation::where("hash", $hash)->first();

        if($activation === NULL) {
            $message = "Your code not work, please contact me.";
            $this->showActivationError($message);
            exit();
        }

        $member = Member::where("idMember", $activation->getIdMember())->first();

        if($member->getIsActive() === 0) {
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
    function showActivationError($message) {
        $this->twigRender("pages/members/activation.html.twig", [
            "message" => $message
        ]);
    }
}