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
            $this->saveActivation($_POST);
        } else if(isset($_SESSION["member_activation"])) {
            $this->saveActivation($_SESSION["member_activation"]);
        } else {
            $this->twigRender("pages/members/activation.html.twig");
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


    // Send the activation mail
    function sendActivationMail($recipient, $hash) {
        $mailURL = "https://$_SERVER[HTTP_HOST]/activate?active=$hash";
        $mailContent = "Click here to activate your account : $url.";

        $mailValues = [
            "to" => $recipient,
            "subject" => "SebBlog - Account activation",
            "content" => $mailContent
        ];
        sendMail($mailValues);

        header("Location /login");
        exit();
    }


    // Activate the account

}