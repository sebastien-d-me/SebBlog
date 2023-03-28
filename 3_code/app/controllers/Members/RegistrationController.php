<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\ActivationController;
use App\Models\LoginCredentials;
use App\Models\Member;
use App\Models\Activation;

class RegistrationController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->checkRegisterFields($_POST);
        } else {
            $this->twigRender("pages/members/registration.html.twig");
        }        
    }

    // Check the fields
    function checkRegisterFields($fields) {
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

        $correctFields ? $this->memberRegister($fields) : $this->showRegistrationError($message);
    }


    // Do the save of the member
    function memberRegister($fields) {
        $member = new Member();
        $member->setRegistrationDate(date("d-m-y"));
        $member->setIsActive(false);
        $member->setIdRole(2);
        $member->save();

        $loginCredentials = new LoginCredentials();
        $loginCredentials->setUsername($fields["register__username"]);
        $loginCredentials->setEmail($fields["register__mail"]);
        $loginCredentials->setPassword($fields["register__password"]);
        $loginCredentials->setIdMember($member->getIdMember());
        $loginCredentials->save();

        $member->setIdLoginCredentials($loginCredentials->getIdLoginCredentials());
        $member->save();

        $dataActivation = [
            "username" => $loginCredentials->getUsername(),
            "email" => $loginCredentials->getEmail(),
            "idMember" => $member->getIdMember()
        ];
        $_SESSION["member_activation"] = $dataActivation;
        header("Location: /member/activation/send-activation?message=Your account has been created. Please active it with the email you received !");
        exit();
    }


    // Display the errors
    function showRegistrationError($message) {
        $this->twigRender("pages/members/registration.html.twig", [
            "message" => $message
        ]);
    }
}