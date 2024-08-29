<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    try {
        include_once '../database/db_handler.php';
        include_once '../models/signup_model.php';
        include_once '../controllers/signup_controller.php';

        $errors = [];

        // Error Handlers
        if (is_empty($username, $password, $email)) {
            $errors["empty_input"] = "Fill in all blank fields!";
        }
        if (is_not_valid_email($email)) {
            $errors["invalid_email"] = "Invalid email used!";
        }

        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "username already used!";
        }


        if (is_email_registered($pdo, $email)) {
            $errors["email_taken"] = " email already registered!";
        }

        require_once '../includes/session.php';

        if ($errors) {
            $_SESSION["error_signup"] = $errors;
            header("Location: ../index.php");
            die();
        }

        create_user($pdo, $username, $email, $password);
        header("Location: ../index.php?signup=success");



        $pdo = null;
        $stmt = null;

        die();
    } catch (PDOException $e) {
        die("Query Failed! " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
