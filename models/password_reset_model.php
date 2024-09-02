<?php

declare(strict_types=1);

function get_user_by_email(object $pdo, string $email)
{
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function store_password_reset_token(object $pdo, int $user_id, string $token, string $expiry_time)
{
    $query = "INSERT INTO password_resets (user_id, token, expiry_time) VALUES (:user_id, :token, :expiry_time)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':expiry_time', $expiry_time, PDO::PARAM_STR);
    $stmt->execute();
}

function get_password_reset_by_token(object $pdo, string $token)
{
    $query = "SELECT * FROM password_resets WHERE token = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_user_password(object $pdo, int $user_id, string $hashed_password)
{
    $query = "UPDATE users SET password = :password WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_password_reset_token(object $pdo, string $token)
{
    $query = "DELETE FROM password_resets WHERE token = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
}
