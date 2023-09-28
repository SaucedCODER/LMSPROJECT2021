<?php
include "./connection/oopconnection.php"; //connections
require_once './methods/manageUser.php'; // Include your user data class

if (isset($_GET['action'])) {
    $userData = new UserData($conn);

    if ($_GET['action'] == 'GET_USER') {
        $id = $_POST['userid'];
        // Call the appropriate method
        $userData->getUserData($id);
    }
    if ($_GET['action'] == 'GET_ALL_USER') {
        // Call the appropriate method
        $userData->getAllUserData();
    }
}
