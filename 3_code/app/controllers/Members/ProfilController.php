<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class ProfilController extends DefaultController {
    // Show the profil
    function index() {
        /*if(!isset($_GET["user"]) && $_SESSION["member_id"] === NULL) {
            header("Location: /error?code=500");
            exit();
        }*/

        if(!isset($_GET["user"]) && $_SESSION["member_id"] !== NULL) {
            $memberId = $_SESSION["member_id"];
            header("Location: /member/profil?user=$memberId");
            exit();
        }

        $memberId = $_GET["user"];

        $credentials = LoginCredentials::where("idMember", $memberId)->first();
        $member = Member::where("idMember", $memberId)->first();

        $informations = [
            "username" => $credentials->getUsername(),
            "registrationDate" => $member->getRegistrationDate()
        ];

        $loggedProfil = false;
        if(isset($_SESSION["member_id"])) {
            intval($_GET["user"]) === $_SESSION["member_id"] ? $loggedProfil = true : $loggedProfil = false;
        }

        $this->twigRender("pages/members/profil.html.twig", [
            "informations" => $informations,
            "loggedProfil" => $loggedProfil
        ]);
    }


    // Edit the profil
    function edit() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
            exit();
        }

        $memberId = $_SESSION["member_id"];
        $credentials = LoginCredentials::where("idMember", $memberId)->first();

        $this->twigRender("pages/members/profil-edit.html.twig", [
            "credentials" => $credentials
        ]);
    }


    // Check the fields
    function check($data) {
        $memberId = $_SESSION["member_id"];
        $credentials = LoginCredentials::where("idMember", $memberId)->first();

        $correctFields = true;

        $email = $data["profil_edit__mail"];
        $password = $data["profil_edit__password"];

        if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $correctFields = false;
        }

        if($password !== "" && strlen($password) < 8) {
            $correctFields = false;
        }

        $checkExisting = LoginCredentials::where("email", $email)->first();
        if ($checkExisting) {
            $correctFields = false;
            $message = "The email address is already in use.";
        }


        $correctFields ? $this->save($credentials, $data) : $this->showError($message);
    }


    // Save the modification
    function save($credentials, $data) {
        if($data["profil_edit__mail"] !== "") {
            $credentials->setEmail(htmlspecialchars($data["profil_edit__mail"]));

            $hash = new Hash();
            $hash->setHash($credentials->getUsername());
            $hash->setIsActive(1);
            $hash->setIdMember($credentials->getIdMember());
            $hash->save();

            $member = Member::where("idMember", $_SESSION["member_id"])->first();
            $member->setIsActive(0);
            $member->save();

            $this->sendMail($credentials->getEmail(), $hash->getHash());
        }

        if($data["profil_edit__password"] !== "") {
            $credentials->setPassword(htmlspecialchars($data["profil_edit__password"]));
        }
        $credentials->save();

        unset($_SESSION["member_id"]);
        unset($_SESSION["member_role"]);
        session_destroy();

        $message = "The modification has been saved. If you have changed your email, please click on the link in the email you received.";
        header("Location: /member/login?message=$message");
        exit();
    }


    // Send the activation mail
    function sendMail($recipient, $hash) {
        $mailURL = "https://$_SERVER[HTTP_HOST]/member/activation/activate?code=$hash";
        $mailContent = "Click here to confirm your email address : $mailURL";

        $mailValues = [
            "to" => $recipient,
            "subject" => "SebBlog - Email modification",
            "content" => $mailContent
        ];
        sendMail($mailValues);
    }


    // Display the errors
    function showError($message) {
        $this->twigRender("pages/members/profil.html.twig", [
            "message" => $message
        ]);
    }
}