<?php

declare(strict_types=1);

function is_empty(string $username, string $password)
{
    if (empty($username) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

function is_user_not_found(bool|array $result)
{
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function is_passwrong_wrong(string $password, string $hashPassword)
{
    return !password_verify($password, $hashPassword);
}
