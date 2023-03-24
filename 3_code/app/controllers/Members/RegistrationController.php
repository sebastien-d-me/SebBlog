<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\RegistrationController;
use App\Models\LoginCredentials;
use App\Models\Member;
use App\Models\Activation;

class RegistrationController extends DefaultController {
    // Functions of the controller
    function index() {
        $html = $this->twig->render("pages/members/registration.html.twig", [
            "route" => $this->route
        ]);
        echo $html;
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $fields = $_POST;
            $this->checkFields($fields);
        }
    }

    function checkFields($fields) {
        $correctFields = true;

        foreach($fields as $field) {
            $field === "" ? $correctFields = false : "";
        }

        if (!filter_var($fields["field__mail"], FILTER_VALIDATE_EMAIL)) {
            $correctFields = false;
        }

        if(!isset($_POST["field__accept"])) {
            $correctFields = false;
        }

        if(isset($_POST["field__important"])) {
            $correctFields = false;
        }

        $correctFields ? $this->saveMember($fields) : "";
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
    }

    function activateAccount() {
        $hashCode = $_GET["active"];
        $activation = Activation::where("hash", $hashCode)->first();
        $idUser = $activation->getIdMember();
        $member = Member::where("idMember", $idUser)->first();
        $member->setIsActive(true);
        $member->save();

        $html = $this->twig->render("pages/members/registration.html.twig", [
            "message" => "Your account is now active",
            "route" => $this->route
        ]);
        echo $html;
    }
}