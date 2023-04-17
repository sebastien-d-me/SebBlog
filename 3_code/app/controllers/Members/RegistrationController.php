<?php

/** Namespace */
namespace App\Controllers;

/** Load */
use App\Models\Hash;
use App\Models\LoginCredentials;
use App\Models\Member;

class RegistrationController extends DefaultController {
  /** Manages the queries */
  function index() {
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $this->check($_POST);
    } else {
      $_SESSION["csrf"] = bin2hex(random_bytes(32));
      $this->twigRender("pages/members/registration.html.twig", [
        "csrf" => $_SESSION["csrf"],
      ]);
    }    
  }

  /** Check the data values */
  function check($data) {
    $username = $data["register__username"];
    $email = $data["register__email"];
    $password = $data["register__password"];
    $accept = isset($_POST["register__accept"]);
    $antiBot = isset($_POST["register__important"]);

    if($data["csrf"] !== $_SESSION["csrf"]) {
      $this->showMessage("Error please retry.");
    }

    foreach($data as $value) {
      if(empty($value)) {
        $this->showMessage("Some fields are not filled in.");
      }
    }

    if (strlen($username) < 3 || strlen($username) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || !$accept || $antiBot) {
      $this->showMessage("Please check the value of the fields.");
    }

    $checkSameCredentials = LoginCredentials::where("username", $username)->orWhere("email", $email)->first();
    if ($checkSameCredentials) {
      $this->showMessage("The username and/or email address is already in use.");
    }

    $this->save($data);
  }

  /** Save the new member */
  function save($data) {
    $member = new Member();
    $member->setRegistrationDate(date("Y-m-d"));
    $member->setIsActive(false);
    $member->setIdRole(2);
    $member->save();

    $loginCredentials = new LoginCredentials();
    $loginCredentials->setUsername(htmlspecialchars($data["register__username"], ENT_QUOTES));
    $loginCredentials->setEmail(htmlspecialchars($data["register__email"], ENT_QUOTES));
    $loginCredentials->setPassword(htmlspecialchars($data["register__password"], ENT_QUOTES));
    $loginCredentials->setIdMember($member->getIdMember());
    $loginCredentials->save();

    $member->setIdLoginCredentials($loginCredentials->getIdLoginCredentials());
    $member->save();

    $hash = new Hash();
    $hash->setHash($loginCredentials->getUsername());
    $hash->setIsActive(1);
    $hash->setIdMember($loginCredentials->getIdMember());
    $hash->save();

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

  /** Display the message */
  function showMessage($message) {
    $_SESSION["csrf"] = bin2hex(random_bytes(32));
    $this->twigRender("pages/members/registration.html.twig", [
      "csrf" => $_SESSION["csrf"],
      "message" => $message
    ]);
  }
}