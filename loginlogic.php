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
            $redirectfile = ($row["type"] == "ADMIN") ? "admins.php" : "members.php";
            $redirectPath = "$redirectfile?userid=$userid&username=$username";
            $response = array("success" => true, "message" => "Authentication successful", "redirect" => $redirectPath);
        } else {
            $response = array("success" => false, "message" => "Your account is not yet approved.");
        }
    } else {
        $response = array("success" => false, "message" => "Don't have an account? Just click the link below!");
    }

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
