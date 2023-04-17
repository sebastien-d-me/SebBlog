<?php

/** Namespace */
namespace App\Controllers;

/** Load */
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class AccountActivationController extends DefaultController {
    /** Manages the the queries */
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else if(isset($_GET["message"])) {
            $this->showMessage($_GET["message"]);
        } else {
            $_SESSION["csrf"] = bin2hex(random_bytes(32));
            $this->twigRender("pages/members/activation.html.twig", [
                "csrf" => $_SESSION["csrf"]
            ]);
        }
    }        

    /** Check the data values */
    function check($data) {
        $email = $data["activation__email"];

        $loginCredentials = LoginCredentials::where("email", htmlspecialchars($email, ENT_QUOTES))->first();
        if($loginCredentials === NULL) {
            $this->showMessage("No account exists with this email address.");
        }

        if($data["csrf"] !== $_SESSION["csrf"]) {
            $this->showMessage("Error please retry.");
        }

        $member = Member::where("idMember", $loginCredentials->getIdMember())->first();
        $hash = Hash::where("idMember", $loginCredentials->getIdMember())->first();
        if($member->getIsActive() === 1) {
            $this->showMessage("Your account is already activated.");
        }

        $getHash = $hash->getHash();
        $mailValues = [
            "to" => $loginCredentials->getEmail(),
            "subject" => "Account activation",
            "content_message" => "Click here to activate your account",
            "content_route" => "/member/activation/activate",
            "content_hash" => "?code=$getHash",
            "header_route" => "/member/login",
            "header_message" => "An email to activate your account has been sent to you."
        ];
        sendMail($mailValues);
    }

    /** Activate the account */
    function activate() {
        $hash = Hash::where("hash", $_GET["code"])->first();

        if($hash === NULL) {
            $this->showMessage("Your code not work, please retry later.");
        }

        $member = Member::where("idMember", $hash->getIdMember())->first();

        if($member->getIsActive() === 0) {
            $hash->setIsActive(0);
            $hash->save();
            $member->setIsActive(true);
            $member->save();
        }

        $message = "Your account is activated.";
        header("Location: /member/login?message=$message");
    }

    /** Display the message */
    function showMessage($message) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
        $this->twigRender("pages/members/activation.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "message" => $message
        ]);
    }
}