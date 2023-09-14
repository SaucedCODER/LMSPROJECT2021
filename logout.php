<?php

include "connection/oopconnection.php";

//status to offline

if (isset($_GET['userid'])) {

    $id = $_GET['userid'];

    $sqlupdate = "UPDATE accounts SET status = 0 WHERE user_id = '$id '";
    $conn->query($sqlupdate) or die("d gumana");
    $conn->close();
    session_start();
    session_unset();
    session_destroy();
    header('Location: /');
}
