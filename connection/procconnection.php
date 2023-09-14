<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db = "librarydb";

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $db);
// Check connection
if (!$conn) {
    die("Unable to Connect database: " . mysqli_connect_error());
}
