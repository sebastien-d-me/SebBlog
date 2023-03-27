<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;

class LoginController extends DefaultController {
    // Checks the status
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->checkFields($_POST);
        } else {
            return $this->twig->render("pages/members/login.html.twig", [
                "route" => $this->route
            ]); 
        }        
    }

    function checkFields($fields) {
        $correctFields = true;
        $message = "";
        
        foreach($fields as $field) {
            $field === "" ? $correctFields = false : $message = "You must fill in all the fields.";
        }

        $correctFields ? $this->connect($fields) : $this->showError($message);
    }

    function connect($fields) {
        $login = $fields["field__username_mail"];
        $password = $fields["field__password"];
        $checkLogin = LoginCredentials::where("username", $login)->orWhere("email", $login)->first();

        if(!empty($checkLogin)) {
            $checkPassword = password_verify($password, $checkLogin->getPassword());
            if($checkPassword === true) {
                $_SESSION["idMember"] = $checkLogin->getIdLoginCredentials();
                $roleMember = Member::find($checkLogin->getIdLoginCredentials())->getIdRole();
                $roleMember === 1 ? $_SESSION["roleMember"] = "Administrator" : $_SESSION["roleMember"] = "Member";
                header("Location: /");
                exit();
            } else {
                $message = "Your password is incorrect";
                $this->showError($message);
            }
        } else {
            $message = "Your username or your mail is incorrect";
            $this->showError($message);
        }
    }

    function showError($message) {
        echo $this->twig->render("pages/members/login.html.twig", [
            "message" => $message,
            "route" => $this->route
        ]); 
    }
}