<?php

declare(strict_types=1);

function get_email(object $conn, string $email)
{
    $query = "SELECT username FROM users WHERE email = :email;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $conn, string $firstname, string $lastname, string $username, string $email, string $password)
{
    $query = "INSERT INTO users (firstname, lastname, username, email, pwd) VALUES (:firstname, :lastname, :username, :email, :pwd);";
    $stmt = $conn->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pwd', $hashedPwd);
    $stmt->execute();
}
