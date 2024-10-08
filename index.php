<?php
require_once 'includes/session.php';
require_once 'views/signup_view.php';
require_once 'views/login_view.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css?v=1">
    <title>Login</title>
</head>

<body>

    <h3>
        <?php
        output_username()
        ?>
    </h3>


    <?php
    if (!isset($_SESSION["user_id"])) { ?>
        <h3>Login</h3>
        <form action="includes/login.php" method="post">
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="password" name="password" id="password" placeholder="Password">
            <button type="submit">Login</button>
            <a href="forgotten_password.php">forgot password?</a>
        </form>
    <?php }
    ?>



    <?php
    check_login_errors();
    ?>

    <h3>Sign Up</h3>
    <form action="includes/signup.php" method="post">
        <?php
        signup_input();
        ?>
        <button type="submit">Sign Up</button>

    </form>

    <?php
    check_signup_errors();
    ?>

    <form action="includes/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>

</body>

</html>