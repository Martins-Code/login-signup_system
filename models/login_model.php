<?php

declare(strict_types=1);

include_once '../database/db_handler.php';


function get_user(object $pdo, string $username)
{
    $query = "SELECT * FROM users where username = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}
