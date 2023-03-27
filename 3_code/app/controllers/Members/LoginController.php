<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\LoginCredentials;
use App\Models\Member;

class LoginController extends DefaultController {
    // Functions of the controller
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $fields = $_POST;
            $this->checkFields($fields);
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

        $message = "";
        if(!empty($checkLogin)) {
            $checkPassword = password_verify($password, $checkLogin->getPassword());
            if($checkPassword === true) {
                ini_set("session.cookie_lifetime", 3600);
                ini_set("session.gc_maxlifetime", 86400);
                session_set_cookie_params(86400);
                
                session_start();
                $_SESSION["idMember"] = $checkLogin->getIdLoginCredentials();
                $roleMember = Member::find($checkLogin->getIdLoginCredentials())->getIdRole();
                $roleName = "";
                switch($roleMember) {
                    case 1:
                        $roleName = "Administrator";
                        break;
                    case 2:
                        $roleName = "Member";
                        break;
                    default:
                        break;
                }
                $_SESSION["roleMember"] = $roleName;
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