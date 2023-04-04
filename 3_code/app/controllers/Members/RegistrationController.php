<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class RegistrationController extends DefaultController {
    // Manages the form and the queries
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else {
            $this->twigRender("pages/members/registration.html.twig");
        }        
    }

    // Check the data values
    function check($data) {
        $username = $data["register__username"];
        $email = $data["register__mail"];
        $password = $data["register__password"];
        $accept = isset($_POST["register__accept"]);
        $antiBot = isset($_POST["register__important"]);

        foreach($data as $value) {
            if(empty($value)) {
                $this->showMessage("Some fields are not filled in.");
                exit();
            }
        }

        if (strlen($username) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || !$accept || $antiBot) {
            $this->showMessage("Please check the value of the fields.");
            exit();
        }

        $checkSameCredentials = LoginCredentials::where("username", $username)->orWhere("email", $email)->first();
        if ($checkSameCredentials) {
            $this->showMessage("The username and/or email address is already in use.");
            exit();
        }

        $this->save($data);
    }

    // Save the new member
    function save($data) {
        $member = new Member();
        $member->setRegistrationDate(date("Y-m-d"));
        $member->setIsActive(false);
        $member->setIdRole(2);
        $member->save();

        $loginCredentials = new LoginCredentials();
        $loginCredentials->setUsername(htmlspecialchars($data["register__username"], ENT_QUOTES));
        $loginCredentials->setEmail(htmlspecialchars($data["register__mail"], ENT_QUOTES));
        $loginCredentials->setPassword(htmlspecialchars($data["register__password"], ENT_QUOTES));
        $loginCredentials->setIdMember($member->getIdMember());
        $loginCredentials->save();

        $member->setIdLoginCredentials($loginCredentials->getIdLoginCredentials());
        $member->save();

        $hash = new Hash();
        $hash->setHash($loginCredentials->getUsername());
        $hash->setIsActive(1);
        $hash->setIdMember($loginCredentials->getIdMember());
        $hash->save();

        $this->sendActivationMail($loginCredentials->getEmail(), $hash->getHash());
    }

    // Send the activation mail
    function sendActivationMail($recipient, $hash) {
        $mailURL = "http://$_SERVER[HTTP_HOST]/member/activation/activate?code=$hash";
        $mailContent = "Click here to activate your account : $mailURL";

        $values = [
            "to" => $recipient,
            "subject" => "SebBlog - Account activation",
            "content" => $mailContent
        ];
        mail($values["to"], $values["subject"], $values["content"], MAIL_HEADERS);

        $message = "An email to activate your account has been sent to you.";
        header("Location: /member/login?message=$message");
        exit();
    }

    // Display the message
    function showMessage($message) {
        $this->twigRender("pages/members/registration.html.twig", [
            "message" => $message
        ]);
    }
}