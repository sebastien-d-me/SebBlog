<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;
use App\Models\Comment;
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class MembersDashboardController extends DefaultController {
    // Show the dashboard
    function index() {
        $data = LoginCredentials::join("member", "logincredentials.idMember", "=", "member.idMember");
        $data = $data->select("logincredentials.idLoginCredentials", "logincredentials.username", "logincredentials.email", "member.idRole", "member.isActive", "member.idMember");
        $data = $data->get();

        $idAdmin = $_SESSION["member_id"];

        $message = "";
        if(isset($_GET["message"])) {
            $message = $_GET["message"];
        }

        $this->twigRender("pages/administrator/dashboard_members.html.twig", [
            "datatable" => $data,
            "idAdmin" => $idAdmin,
            "message" => $message
        ]);
    }

    // Change to member
    function changeMember() {
        $userId = $_GET["user"];
        $user = Member::where("idMember", $userId)->first();
        $user->setIdRole(2);
        $user->save();

        $message = "The role of the account (ID : $userId) has been changed.";
        header("Location: /admin/dashboard/members?message=$message");
    }

    // Change to admin
    function changeAdmin() {
        $userId = $_GET["user"];
        $user = Member::where("idMember", $userId)->first();
        $user->setIdRole(1);
        $user->save();

        $message = "The role of the account (ID : $userId) has been changed.";
        header("Location: /admin/dashboard/members?message=$message");
    }

    // Desactivate the account
    function desactivate() {
        $userId = $_GET["user"];
        $user = Member::where("idMember", $userId)->first();
        $user->setIsActive(0);
        $user->save();

        $message = "The account (ID : $userId) has been desactived.";
        header("Location: /admin/dashboard/members?message=$message");
    }

    // Activate the account
    function activate() {
        $userId = $_GET["user"];
        $user = Member::where("idMember", $userId)->first();
        $user->setIsActive(1);
        $user->save();

        $message = "The account (ID : $userId) has been activated.";
        header("Location: /admin/dashboard/members?message=$message");
    }

    // Delete the account
    function delete() {
        $userId = $_GET["user"];

        Comment::where("idMember", $userId)->delete();
        Hash::where("idMember", $userId)->delete();
        LoginCredentials::where("idMember", $userId)->delete();
        Member::where("idMember", $userId)->delete();

        $message = "The account (ID : $userId) has been deleted.";
        header("Location: /admin/dashboard/members?message=$message");
    }
}   