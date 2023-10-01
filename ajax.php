<?php
include "./connection/oopconnection.php"; //connections
require_once './methods2/manageUser.php'; // Include your user data class

if (isset($_GET['action'])) {
    $userCrud = new UserCrud($conn);
    if ($_GET['action'] == 'INSERT_USER' || $_GET['action'] == 'UPDATE_USER') {
        $data = array('userData' => [
            'Fname' => (string)$_POST['Fname'],
            'Lname' => (string)$_POST['Lname'],
            'ResAdrs' => (string)$_POST['ResAdrs'],
            'OfcAdrs' => (string)$_POST['OfcAdrs'],
            'LandlineNo' => (string)$_POST['LandlineNo'],
            'MobileNo' => (string)$_POST['MobileNo'],
            'Email' => (string)$_POST['Email'],
            'Gender' => (string)$_POST['Gender'],
        ], 'accountData' => [
            'username' => (string)$_POST['username'],
            'type' => (string)$_POST['type'],
            'status' => 0
        ]);
    }
    if (isset($_POST['password'])) {
        $data['accountData']['password'] = (string)$_POST['password'];
    }


    $imagefile = !isset($_FILES['file']) ? false : $_FILES['file'];

    if ($_GET['action'] == 'GET_USER') {
        $id = $_POST['userid'];
        $userCrud->getUserData($id);
    }
    if ($_GET['action'] == 'GET_ALL_USER') {
        $userCrud->getAllUserData();
    }
    if ($_GET['action'] == 'INSERT_USER') {
        $userCrud->insertUser($data, $imagefile);
    }
    if ($_GET['action'] == 'UPDATE_USER') {
        // adding the user_id 
        $data['id'] = (string)$_GET['user_id'];
        $userCrud->updateUser($data, $imagefile);
    }
    if ($_GET['action'] == 'DELETE_USER') {

        $idToDelete = (string)$_GET['user_id'];
        $result =  $userCrud->deleteUser($idToDelete);
        $response = [
            'success' => $result,
            'message' => $result ? "User with ID '#$idToDelete' has been successfully deleted" : "Failed to delete the User with ID ''#$idToDelete'.'"
        ];
        echo json_encode($response);
        exit;
    }
}
