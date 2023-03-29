<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class RegistrationController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->checkFields($_POST);
        } else {
            $this->twigRender("pages/members/registration.html.twig");
        }        
    }


    // Check the fields
    function checkFields($fields) {
        $correctFields = true;

        foreach($fields as $field) {
            empty($field) ? $correctFields = false : "";
        }

        if (strlen($fields["register__username"]) < 3 || !filter_var($fields["register__mail"], FILTER_VALIDATE_EMAIL) || strlen($fields["register__password"]) < 8 || !isset($_POST["register__accept"]) || isset($_POST["register__important"])) {
            $correctFields = false;
        }

        $checkExisting = LoginCredentials::where("username", $fields["register__username"])->orWhere("email", $fields["register__mail"])->first();
        if ($checkExisting) {
            $correctFields = false;
            $message = "The username and/or email address is already in use.";
        }

        $correctFields ? $this->saveMember($fields) : $this->showError($message);
    }


    // Do the save of the member
    function saveMember($fields) {
        $member = new Member();
        $member->setRegistrationDate(date("d-m-y"));
        $member->setIsActive(false);
        $member->setIdRole(2);
        $member->save();

        $loginCredentials = new LoginCredentials();
        $loginCredentials->setUsername(htmlspecialchars($fields["register__username"], ENT_QUOTES));
        $loginCredentials->setEmail(htmlspecialchars($fields["register__mail"], ENT_QUOTES));
        $loginCredentials->setPassword(htmlspecialchars($fields["register__password"], ENT_QUOTES));
        $loginCredentials->setIdMember($member->getIdMember());
        $loginCredentials->save();

        $member->setIdLoginCredentials($loginCredentials->getIdLoginCredentials());
        $member->save();

        $hash = new Hash();
        $hash->setHash($loginCredentials->getUsername());
        $hash->setIsActive(1);
        $hash->setIdMember($loginCredentials->getIdMember());
        $hash->save();
        
        $this->sendMail($loginCredentials->getEmail(), $hash->getHash());
        exit();
    }


    // Send the activation mail
    function sendMail($recipient, $hash) {
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


    // Display the errors
    function showError($message) {
        $this->twigRender("pages/members/registration.html.twig", [
            "message" => $message
        ]);
    }
}