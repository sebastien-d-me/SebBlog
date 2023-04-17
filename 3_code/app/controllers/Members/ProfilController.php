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
    function index(): void {
        if(!isset($_GET["user"]) && $_SESSION["member_id"] !== NULL) {
            $memberId = $_SESSION["member_id"];
            header("Location: /member/profil?user=$memberId");
            return;
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

        $_SESSION["csrf"] = bin2hex(random_bytes(32));

        $this->twigRender("pages/members/profil/profil.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "informations" => $informations,
            "currentProfil" => $currentProfil
        ]);
    }

    // Manage the edit form
    function edit(): void {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
            return;
        }

        $loginCredentials = LoginCredentials::where("idMember", $_SESSION["member_id"])->first();

        $_SESSION["csrf"] = bin2hex(random_bytes(32));

        $this->twigRender("pages/members/profil/profil-edit.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "credentials" => $loginCredentials
        ]);
    }

    // Check the fields
    function check(array $data): void {
        $loginCredentials = LoginCredentials::where("idMember", $_SESSION["member_id"])->first();

        $password = $data["profil_edit__password"];
        $currentPassword = $data["profil_edit__current-password"];

        if($data["csrf"] !== $_SESSION["csrf"]) {
            $this->showMessage("Error please retry.");
            return;
        }

        if($password !== "" && strlen($password) < 8) {
            $this->showMessage("Your new password is not strong enough.");
            return;
        }

        $checkPassword = password_verify($currentPassword, $loginCredentials->getPassword());
        if(!$checkPassword || $currentPassword === "") {
            $this->showMessage("Your current password is incorrect.");
            return;
        }

        $this->save($loginCredentials, $data);
    }

    // Save the modification
    function save(object $loginCredentials, array $data): void {
        $newPassword = $data["profil_edit__password"];

        if($newPassword !== "") {
            $loginCredentials->setPassword(htmlspecialchars($newPassword), ENT_QUOTES);
            $loginCredentials->save();

            unset($_SESSION["member_id"]);
            unset($_SESSION["member_reset"]);
            unset($_SESSION["member_role"]);

            $message = "Your modification has been saved. Please reconnect.";
            header("Location: /member/login?message=$message");
            return;
        } else {
            header("Location: /member/profil");
            return;
        }
    }

    // Delete the account
    function delete(): void {
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
            return;
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
    function showMessage(string $message): void {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
        $this->twigRender("pages/members/profil/profil-edit.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "message" => $message
        ]);
    }
}