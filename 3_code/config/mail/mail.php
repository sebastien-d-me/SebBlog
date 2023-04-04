<?php

// SMTP Settings
ini_set("SMTP",  "127.0.0.1");
ini_set("smtp_port", 25);

// Mail headers
define("MAIL_HEADERS", "From: noreply@sebblog.sebastien-d.me" . "\r\n" . "X-Mailer: PHP/" . phpversion());

// Send the mail
function sendMail($values) {
    $mailInformations = [
        "to" => $values["to"],
        "subject" => "SebBlog - ".$values["subject"],
        "content" => $values["content_message"]." : http://$_SERVER[HTTP_HOST]".$values["content_route"].$values["content_hash"]
    ];
    
    mail($mailInformations["to"], $mailInformations["subject"], $mailInformations["content"], MAIL_HEADERS);

    header("Location: ".$values["header_route"]."?message=".$values["header_message"]);
    exit();
}