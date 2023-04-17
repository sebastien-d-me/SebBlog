<?php

// Namespace
namespace App\Controllers;

// Load
use App\Controllers\DefaultController;

class HomeController extends DefaultController {
    // Show the homepage
    function index() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->check($_POST);
        } else if(isset($_GET["message"])) {
            $this->showMessage($_GET["message"]);
            exit();
        } else {
            $_SESSION["csrf"] = bin2hex(random_bytes(32));
            $this->twigRender("pages/index.html.twig", [
                "csrf" => $_SESSION["csrf"],
            ]);
        }
    }
    
    // Check the data values
    function check($data) {
        $fullName = $data["contact__name"];
        $email = $data["contact__email"];
        $subject = $data["contact__subject"];
        $message = $data["contact__message"];
        $antiBot = isset($data["contact__important"]);

        if($data["csrf"] !== $_SESSION["csrf"]) {
            $this->showMessage("Error please retry.");
            exit();
        }

        foreach($data as $value) {
            if(empty($value)) {
                $this->showMessage("Some fields are not filled in.");
                exit();
            }
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $antiBot) {
            $this->showMessage("Please check the value of the fields.");
            exit();
        }

        $this->contactSubmit($data);
    }

    // Send me the informations
    function contactSubmit($data) {
        $formValues = "<b>Full name : </b>".htmlspecialchars($data["contact__name"], ENT_QUOTES)."<br>";
        $formValues.= "<b>Email name : </b>".htmlspecialchars($data["contact__email"], ENT_QUOTES)."<br>";
        $formValues.= "<b>Subject : </b>".htmlspecialchars($data["contact__subject"], ENT_QUOTES)."<br>";
        $formValues.= "<b>Message : </b>".htmlspecialchars($data["contact__message"], ENT_QUOTES)."<br><br>";

        $mailValues = [
            "to" => "sebastien.delahaye.contact@gmail.com",
            "subject" => "Contact request",
            "content_message" => $formValues."Contact from",
            "content_route" => "",
            "content_hash" => "",
            "header_route" => "/",
            "header_message" => "Your email has been sent. You will receive a reply shortly."
        ];
        sendMail($mailValues);
    }

    // Display the message
    function showMessage($message) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
        $this->twigRender("pages/index.html.twig", [
            "csrf" => $_SESSION["csrf"],
            "message" => $message
        ]);
    }
}