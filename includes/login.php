<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        include_once '../database/db_handler.php';
        include_once '../models/login_model.php';
        include_once '../controllers/login_controller.php';

        $errors = [];

        // Error Handlers
        if (is_empty($username, $password)) {
            $errors["empty_input"] = "Fill in all blank fields!";
        } else {
            $result = get_user($pdo, $username);

            if (is_user_not_found($result)) {
                $errors["user_notFound"] = "Username not found!";
            } elseif (is_passwrong_wrong($password, $result['password'])) {
                $errors["wrong_password"] = "Incorrect Password!";
            }
        }

        require_once '../includes/session.php';

        if ($errors) {
            $_SESSION["error_login"] = $errors;
            header("Location: ../index.php");
            die();
        }

        $_SESSION['user_id'] = $result["id"];
        $_SESSION['username'] = $result["username"];


        header("Location: ../index.php?login=success");

        $pdo = null;

        die();
    } catch (PDOException $e) {
        die("Query Failed! " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
