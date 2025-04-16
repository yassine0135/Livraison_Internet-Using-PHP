<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Gmail SMTP settings
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'redaelboukri@gmail.com';
$smtpPassword = 'nadicanadii';

// Form data
$name = $_POST['inputName'];
$email = $_POST['inputEmail'];
$message = $_POST['validationTextarea'];

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Set up SMTP settings
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->Port = $smtpPort;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;

    // Set up email headers
    $mail->setFrom($email, $name);
    $mail->addAddress('recipient-email@gmail.com', 'Recipient Name');
    $mail->Subject = 'Message from Website';

    // Set up email body
    $mail->Body = $message;

    // Send the email
    $mail->send();
    echo 'Message sent successfully!';
} catch (Exception $e) {
    echo 'Error sending message: ' . $mail->ErrorInfo;
}