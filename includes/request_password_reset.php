<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Composer's autoload file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    include_once '../database/db_handler.php';
    include_once '../models/password_reset_model.php';

    $user = get_user_by_email($pdo, $email);
    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

        store_password_reset_token($pdo, $user['id'], $token, $expiry_time);

        $reset_link = "http://localhost/login_system/includes/reset_password.php?token=" . $token;

        $mail = new PHPMailer(true);

        try {
            include_once 'password.php';
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // Mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'a0d39af9fcd13d'; // Your Mailtrap username
            $mail->Password = server_password(); // Your Mailtrap password
            $mail->Port = 2525; // Mailtrap port
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

            // Recipients
            $mail->setFrom('your_email@example.com', 'Your Name'); // Replace with your email (doesn't need to be real for Mailtrap)
            $mail->addAddress($email); // The email of the user requesting the password reset

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail->send();
            echo 'Password reset email has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email address not found!";
    }
}
