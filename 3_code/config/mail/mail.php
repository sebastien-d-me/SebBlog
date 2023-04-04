<?php

// SMTP Settings
ini_set("SMTP",  "127.0.0.1");
ini_set("smtp_port", 25);

// Mail headers
define("MAIL_HEADERS", "From: noreply@sebblog.sebastien-d.me" . "\r\n" . "X-Mailer: PHP/" . phpversion());