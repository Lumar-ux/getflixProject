<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer();

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = 'in-v3.mailjet.com';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 80;
$mail->Username = "7c9805b13f5dc7bf4100038ead1f7aae";
$mail->Password = 'f7a322b54ee229a4195f4b0c96700041';

$mail->isHTML(true);

return $mail;
