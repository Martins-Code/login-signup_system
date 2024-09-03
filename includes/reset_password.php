<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <form action="reset_password.php" method="post">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" required>
        <input type="password" name="password" placeholder="Enter new password" required>
        <button type="submit">Reset Password</button>
    </form>

    <?php
    include_once '../database/db_handler.php';
    require '../vendor/autoload.php';
    include_once '../models/password_reset_model.php'; // Correct model file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = $_POST["token"];
        $new_password = $_POST["password"];

        $reset_request = get_password_reset_by_token($pdo, $token);
        if ($reset_request && new DateTime() < new DateTime($reset_request['expiry_time'])) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            update_user_password($pdo, $reset_request['user_id'], $hashed_password);
            delete_password_reset_token($pdo, $token);
            echo "Password reset successful!";

            header("Location: ../index.php");
        } else {
            echo "Invalid or expired token!";
        }
    }
    ?>
</body>

</html>