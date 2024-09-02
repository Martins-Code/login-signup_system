<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once 'password.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    include_once '../database/db_handler.php';
    include_once '../models/password_reset_model.php';

    $user = get_user_by_email($pdo, $email);
    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

        store_password_reset_token($pdo, $user['id'], $token, $expiry_time);

        $reset_link = "http://localhost/login_system/index.php/includes/reset_password.php?token=" . $token;

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'martinssolution0@gmail.com';
            $mail->Password = server_password(); // Used App Password here
            $mail->Port = 587;
            $mail->SMTPSecure = 'tsl';

            // Recipients
            $mail->setFrom('martinssolution0@gmail.com', 'MartinsCode');
            $mail->addAddress($email);

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
