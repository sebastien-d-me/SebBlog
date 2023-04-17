<?php

// SMTP Settings
ini_set("SMTP",  "127.0.0.1");
ini_set("smtp_port", 25);

// Mail headers
$headers = [
    "MIME-Version: 1.0",
    "Content-type:text/html;charset=UTF-8",
    "From: noreply@sebblog.sebastien-d.me",
    "X-Mailer: PHP/" . phpversion()
];
define("MAIL_HEADERS", implode("\r\n", $headers));

// Send the mail
function sendMail($values) {
    $mailInformations = [
        "to" => $values["to"],
        "subject" => "SebBlog - ".$values["subject"],
        "content" => $values["content_message"]." : <a href='http://$_SERVER[HTTP_HOST]".$values["content_route"].$values["content_hash"]."'>here</a>"
    ];
    
    mail($mailInformations["to"], $mailInformations["subject"], $mailInformations["content"], MAIL_HEADERS);

    header("Location: ".$values["header_route"]."?message=".$values["header_message"]);
}