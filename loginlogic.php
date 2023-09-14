<?php
session_start();
include "connection/oopconnection.php";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $user = $conn->real_escape_string($_POST["username"]);
    $pass = $conn->real_escape_string($_POST["password"]);

    $sql = "SELECT * FROM accounts WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows) {
        $row = $res->fetch_assoc();
        $userid = $row['user_id'];
        $username = $row['username'];

        if ($row['status'] == 0) {
            $sqlupdatestatus = "UPDATE accounts SET status = 0 WHERE user_id = $userid";
            $conn->query($sqlupdatestatus) or die("Fatal error");

            $redirectURL = ($row["type"] == "ADMIN") ? "admins.php" : "members.php";
            header("Location: $redirectURL?userid=$userid&username=$username");
            exit;
        } else {
            $_SESSION['message'] = "Your account is not yet approved.";
            header('Location: /');
            exit;
        }
    } else {
        $_SESSION['message'] = "Don't have an account? Just click the link below!";
        header('Location: /');
        exit;
    }
}
