<?php

// SMTP Settings
ini_set("SMTP",  "127.0.0.1");
ini_set("smtp_port", 25);


// Mail headers
define("MAIL_HEADERS", "From: noreply@sebblog.sebastien-d.me" . "\r\n" . "X-Mailer: PHP/" . phpversion());


// Check values
function checkMailValues($values) {
    $correctValues = true;

    foreach($values as $value) {
        empty($value) ? $correctValues = false : "";
    }

    if (!filter_var($values["to"], FILTER_VALIDATE_EMAIL)) {
        $correctValues = false;
    }

    return $correctValues;
}


// Mail status
function sendMail($values) {
    $currentURL = $_SERVER["REQUEST_URI"];
    $checkValues = checkMailValues($values);

    if($checkValues === true) {
        mail($values["to"], $values["subject"], $values["content"], MAIL_HEADERS);
        return true;
    } else {
        return false;
    }
}
?>