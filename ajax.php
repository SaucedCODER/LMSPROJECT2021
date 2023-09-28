<?php
include "./connection/oopconnection.php"; //connections
require_once './methods/manageUser.php'; // Include your user data class

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'GET_USER') {
        $id = $_POST['userid'];
        // Create instances of your classes
        $userData = new UserData($conn);
        // Call the appropriate method
        $userData->getUserData($id);
    }
}
