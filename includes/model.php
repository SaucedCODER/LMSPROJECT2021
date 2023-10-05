<?php

declare(strict_types=1);

function get_username(object $pdo, string $username)
{
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email)
{
    $query = "SELECT username FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $firstname, string $lastname, string $username, string $email, string $resaddr, string $offaddr, string $mobileno, string $landlineno, string $pwd)
{
    $query = "INSERT INTO users (firstname, lastname, username, email, resaddrs, offaddrs, mobileno, landlineno, studentsid, pwd ) VALUES (:firstname, :lastname, :username, :email, :resaddrs, :offaddrs, :mobileno, :landlineno, :pwd);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':resaddrs', $resaddr);
    $stmt->bindParam(':offaddrs', $offaddr);
    $stmt->bindParam(':mobileno', $mobileno);
    $stmt->bindParam(':landlineno', $landlineno);
    $stmt->bindParam(':pwd', $hashedPwd);
    $stmt->execute();
}
