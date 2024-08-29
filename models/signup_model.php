<?php

declare(strict_types=1);

include_once '../database/db_handler.php';

function get_username(object $pdo, string $username)
{
    $query = "SELECT username FROM users where username = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function get_email(object $pdo, string $email)
{
    $query = "SELECT email FROM users where email = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function set_user(object $pdo, string $username, string $email, string $password)
{
    $query = "INSERT INTO  users(username, email, password) VALUES(?, ?, ?);";
    $stmt = $pdo->prepare($query);

    $option = [
        'cost' => 12
    ];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $option);

    $stmt->execute([$username, $email, $hashedPassword]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}
