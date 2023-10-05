<?php

$host = "localhost";
$dbname = "librarydb";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
