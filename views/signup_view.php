<?php

declare(strict_types=1);


function signup_input()
{
    // For the username input field
    if (isset($_SESSION['signup_input']['username']) && !isset($_SESSION['error_signup']['username_taken'])) {
        echo '<input type="text" name="username" id="username" placeholder="Username" value="' . htmlspecialchars($_SESSION['signup_input']['username']) . '">';
    } else {
        echo '<input type="text" name="username" id="username" placeholder="Username">';
    }

    // For the email input field
    if (isset($_SESSION['signup_input']['email']) && !isset($_SESSION['error_signup']['email_taken']) && !isset($_SESSION['error_signup']['invalid_email'])) {
        echo '<input type="email" name="email" id="email" placeholder="Email" value="' . htmlspecialchars($_SESSION['signup_input']['email']) . '">';
    } else {
        echo '<input type="email" name="email" id="email" placeholder="Email">';
    }

    // Password input field does not need to repopulate for security reasons
    echo '<input type="password" name="password" id="password" placeholder="Password">';
}


function check_signup_errors()
{
    if (isset($_SESSION["error_signup"])) {
        $errors = $_SESSION["error_signup"];

        echo '<br>';

        foreach ($errors as $error) {
            echo "<p class='form-error'>" . htmlspecialchars($error)  . "</p>";
        }

        unset($_SESSION["error_signup"]);
    } else if ($_GET["signup"] && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p class='form-success'> Sign Up Successfull! </p>";
    }
}
