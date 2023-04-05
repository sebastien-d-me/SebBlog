<?php

// Namespace
namespace App\Controllers;

// Load
use App\Models\Comment;
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class ProfilController extends DefaultController {
    // Manages the queries
    function index() {
        if(!isset($_GET["user"]) && $_SESSION["member_id"] !== NULL) {
            $memberId = $_SESSION["member_id"];
            header("Location: /member/profil?user=$memberId");
            exit();
        }

        $loginCredentials = LoginCredentials::where("idMember", $_GET["user"])->first();
        $member = Member::where("idMember", $_GET["user"])->first();

        $informations = [
            "username" => $loginCredentials->getUsername(),
            "registrationDate" => $member->getRegistrationDate()
        ];

        $currentProfil = false;
        if(isset($_SESSION["member_id"])) {
            intval($_GET["user"]) === $_SESSION["member_id"] ? $currentProfil = true : $currentProfil = false;
        }

        $this->twigRender("pages/members/profil/profil.html.twig", [
            "informations" => $informations,
            "currentProfil" => $currentProfil
        ]);
    }

    // Manage the edit form
    function edit() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
            exit();
        }

        $loginCredentials = LoginCredentials::where("idMember", $_SESSION["member_id"])->first();

        $this->twigRender("pages/members/profil/profil-edit.html.twig", [
            "credentials" => $loginCredentials
        ]);
    }

    // Check the fields
    function check($data) {
        $loginCredentials = LoginCredentials::where("idMember", $_SESSION["member_id"])->first();

        $password = $data["profil_edit__password"];
        $currentPassword = $data["profil_edit__current-password"];

        if($password !== "" && strlen($password) < 8) {
            $this->showMessage("Your new password is not strong enough.");
            exit();
        }

        $checkPassword = password_verify($currentPassword, $loginCredentials->getPassword());
        if(!$checkPassword || $currentPassword === "") {
            $this->showMessage("Your current password is incorrect.");
            exit();
        }

        $this->save($loginCredentials, $data);
    }

    // Save the modification
    function save($loginCredentials, $data) {
        $newPassword = $data["profil_edit__password"];

        if($newPassword !== "") {
            $loginCredentials->setPassword(htmlspecialchars($newPassword));
            $loginCredentials->save();

            unset($_SESSION["member_id"]);
            unset($_SESSION["member_reset"]);
            unset($_SESSION["member_role"]);

            $message = "Your modification has been saved. Please reconnect.";
            header("Location: /member/login?message=$message");
            exit();
        } else {
            header("Location: /member/profil");
            exit();
        }
    }

    // Delete the account
    function delete() {
        if(isset($_GET["code"])) {
            Comment::where("idMember", $_SESSION["member_id"])->delete();
            Hash::where("idMember", $_SESSION["member_id"])->delete();
            LoginCredentials::where("idMember", $_SESSION["member_id"])->delete();
            Member::where("idMember", $_SESSION["member_id"])->delete();

            unset($_SESSION["member_id"]);
            unset($_SESSION["member_reset"]);
            unset($_SESSION["member_role"]);
    
            $message = "Your account has been deleted.";
            header("Location: /member/login?message=$message");
            exit();
        } else {
            $loginCredentials = LoginCredentials::where("idMember", $_SESSION["member_id"])->first();

            $hash = new Hash();
            $hash->setHash($loginCredentials->getUsername());
            $hash->setIsActive(1);
            $hash->setIdMember($loginCredentials->getIdMember());
            $hash->save();

            $getHash = $hash->getHash();

            unset($_SESSION["member_reset"]);
            unset($_SESSION["member_role"]);

            $mailValues = [
                "to" => $loginCredentials->getEmail(),
                "subject" => "Delete validation",
                "content_message" => "Click here to delete your account",
                "content_route" => "/member/profil/delete",
                "content_hash" => "?code=$getHash",
                "header_route" => "/member/login",
                "header_message" => "To confirm the deletion of you account, please click on the link in the email you received."
            ];
            sendMail($mailValues);
        }
    }

    // Display the message
    function showMessage($message) {
        $this->twigRender("pages/members/profil/profil-edit.html.twig", [
            "message" => $message
        ]);
    }
}