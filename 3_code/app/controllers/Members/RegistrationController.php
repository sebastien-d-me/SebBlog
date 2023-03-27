<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;
use App\Models\Activation;

class RegistrationController extends DefaultController {
    // Functions of the controller
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $fields = $_POST;
            $this->checkFields($fields);
        } else {
            return $this->twig->render("pages/members/registration.html.twig", [
                "message" => "",
                "route" => $this->route
            ]);
        }        
    }

    function checkFields($fields) {
        $correctFields = true;
        $message = "";

        foreach($fields as $field) {
            $field === "" ? $correctFields = false : "";
        }

        if(strlen($fields["field__username"]) < 3) {
            $correctFields = false;
        }

        if (!filter_var($fields["field__mail"], FILTER_VALIDATE_EMAIL)) {
            $correctFields = false;
        }

        if(strlen($fields["field__password"]) < 8) {
            $correctFields = false;
        }

        if(!isset($_POST["field__accept"])) {
            $correctFields = false;
        }

        if(isset($_POST["field__important"])) {
            $correctFields = false;
        }

        $checkExisting = LoginCredentials::where("username", $fields["field__username"])->orWhere("email", $fields["field__mail"])->first();
        if ($checkExisting) {
            $correctFields = false;
            $message = "The username and/or email address is already in use.";
        }

        $correctFields ? $this->saveMember($fields) : $this->showError($message);
    }

    function saveMember($fields) {
        $member = new Member();
        $member->setRegistrationDate(date("d-m-y"));
        $member->setIsActive(false);
        $member->setIdRole(2);
        $member->save();

        $loginCredentials = new LoginCredentials();
        $loginCredentials->setUsername($fields["field__username"]);
        $loginCredentials->setEmail($fields["field__mail"]);
        $loginCredentials->setPassword($fields["field__password"]);
        $loginCredentials->setIdMember($member->getIdMember());
        $loginCredentials->save();

        $member->setIdLoginCredentials($loginCredentials->getIdLoginCredentials());
        $member->save();

        $validationHash = password_hash($fields["field__username"], PASSWORD_DEFAULT);
        $validationURL = "https://$_SERVER[HTTP_HOST]/activate?active=$validationHash";
        $activation = new Activation();
        $activation->setHash($validationHash);
        $activation->setIdMember($member->getIdMember());
        $activation->save();

        $this->sendValidation($fields["field__mail"], $validationURL);
    }

    function sendValidation($recipient, $url) {
        $values = [
            "to" => $recipient,
            "subject" => "SebBlog - Account activation",
            "content" => "Click here to activate your account : $url"
        ];
        sendMail($values);

        header("Location: /login");
        exit();
    }

    function showError($message) {
        echo $this->twig->render("pages/members/registration.html.twig", [
            "message" => $message,
            "route" => $this->route
        ]);
    }

    function activateAccount() {
        $hashCode = $_GET["active"];
        $activation = Activation::where("hash", $hashCode)->first();
        $idUser = $activation->getIdMember();
        $member = Member::where("idMember", $idUser)->first();
        $member->setIsActive(true);
        $member->save();

        echo $this->twig->render("pages/members/registration.html.twig", [
            "message" => "Your account is now active.",
            "route" => $this->route
        ]);
    }
}