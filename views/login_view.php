<?php

declare(strict_types=1);


function check_login_errors()
{
    if (isset($_SESSION["error_login"])) {
        $errors = $_SESSION["error_login"];

        echo '<br>';

        foreach ($errors as $error) {
            echo "<p class='form-error'>" . htmlspecialchars($error) . "</p>";
        }

        unset($_SESSION["error_login"]);
    } else if ($_GET["login"] && $_GET["login"] === "success") {
        echo "<br>";
        echo "<p class='form-success'> Login Successfull! </p>";
    }
}

function output_username()
{
    if (isset($_SESSION["user_id"])) {
        echo "You are logged in as " . $_SESSION["username"];
    } else {
        echo 'You are logged out';
    }
}
