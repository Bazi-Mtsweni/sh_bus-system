<?php
require "../db/conn.php";
include "../includes/responses.php";

require "../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($data, $env)
{

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = $env['EMAIL_USERNAME'];
        $mail->Password = $env['EMAIL_PASSWORD'];

        $mail->setFrom("strivehigh53@gmail.com");
        $mail->addAddress($data['clientEmail'], "User");

        $mail->Subject = $data['subject'];
        $mail->isHTML(true);
        $mail->Body = $data['message'];

        $mail->send();

        // Send JSON response for redirect
        header('Content-Type: application/json');
        response(true, "A password reset link has been sent to your email.");
        exit;
    } catch (Exception $e) {
        response(false, "Email could not be sent. Please try again.");
        echo "Mailer error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT parentId FROM parents WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate secure token and expiration time
        $token = bin2hex(random_bytes(32));
        $expires = date("U") + 1800; // Token expires in 30 minutes (60s x 30)

        // Store the token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();

        // Create the password reset link
        $resetLink = "http://localhost/sh-bus-system/public/views/forms/password_reset.php?token=$token&email=" . urlencode($email);

        //Get .env
        $envFilePath = __DIR__ . '/../includes/.env';
        $env = parse_ini_file($envFilePath);

        // Construct email message
        $subject = "Password Reset Request";
        $message = '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
                    <head>
                        <meta charset="UTF-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    </head>
                    <body>
                        <h2>Password reset Link</h2></br>
                        <p>We received a request to reset your password. Click the button below to reset it:</p> 
                        <p style="margin:1rem 0; padding: 0.7rem 1rem; background-color: #045eb7; width: fit-content;"><a href=" '.$resetLink.' " style="color: #ffffff;">Reset Your Password</a></p>
                        <p><strong>Important Note: </strong>The reset link will expire in 30 minutes</p>
                    </body>
                </html>
        ';
        $data = [
            'clientEmail' => $email,
            'subject' => $subject,
            'message' => $message
        ];

        sendEmail($data, $env);

    } else {
        response(false, "No account found with that email");
    }
} else {
    echo "Invalid Request Method";
}
