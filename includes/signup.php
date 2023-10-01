<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $resaddr = $_POST['resaddr'];
    $offaddr = $_POST['offaddr'];
    $mobileno = $_POST['mobileno'];
    $landlineno = $_POST['landlineno'];
    $male = $_POST['male'];
    $female = $_POST['female'];
    $studid = $_POST['studid'];
    $pwd = $_POST['pwd'];
    $confirmpwd = $_POST['confirmpwd'];

    try {

        require_once "../connection/oopconnection.php";
        require_once "../connection/procconnection.php";
        require_once "model.php";
        require_once "controller.php";

        // Error hadlers

        $errors = [];

        if (empty_firstname($firstname)) {
            $errors['empty_firstname'] = "firstname is required!";
        }
        if (empty_lastname($lastname)) {
            $errors['empty_lastname'] = "lastname is required!";
        }
        if (empty_resaddr($resaddr)) {
            $errors['empty_resaddr'] = "resaddr is required!";
        }
        if (empty_offaddr($offaddr)) {
            $errors['empty_offaddr'] = "offaddr is required!";
        }
        if (empty_mobileno($mobileno)) {
            $errors['empty_mobileno'] = "mobileno is required!";
        }
        if (empty_landlineno($landlineno)) {
            $errors['empty_landlineno'] = "landlineno is required!";
        }
        if (empty_gender($male, $female)) {
            $errors['empty_gender'] = "gender is required!";
        }
        if (empty_pwd($pwd, $confirmpwd)) {
            $errors['empty_pwd'] = "password is required!";
        }
        if (email_invalid($email) && strlen($email) > 0) {
            $errors['email_invalid'] = "Invalid email!";
        }
        if (email_registered($conn, $email)) {
            $errors['email_taken'] = "Email already registered!";
        }

        require_once "session.php";

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signup_data = [
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "resaddr" => $resaddr,
                "offaddr" => $offaddr,
                "mobileno" => $mobileno,
                "landlineno" => $landlineno,
                "male" => $male,
                "female" => $female,
                "studid" => $studid,
                "pwd" => $pwd,
                "confirmpwd" => $confirmpwd
            ];

            $_SESSION["signup_data"] = $signup_data;

            header("Location: ../index.php");
            die();
        }

        create_user($conn, $firstname, $lastname, $username, $email, $password);
        header("Location: ../index.php?signup=success");
    } catch (PDOException $e) {
        die("Query Error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
