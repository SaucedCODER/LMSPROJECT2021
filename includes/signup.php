<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $resaddr = $_POST['resaddr'];
    $offaddr = $_POST['offaddr'];
    $mobileno = $_POST['mobileno'];
    $landlineno = $_POST['landlineno'];
    $pwd = $_POST['pwd'];

    try {

        require_once "../connection/dbh.php";
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
        if (username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }
        if (email_invalid($email) && strlen($email) > 0) {
            $errors['email_invalid'] = "Invalid email!";
        }
        if (email_registered($pdo, $email)) {
            $errors['email_taken'] = "Email already registered!";
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

        require_once "session.php";

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signup_data = [
                "firstname" => $firstname,
                "lastname" => $lastname,
                "username" => $username,
                "email" => $email,
                "resaddr" => $resaddr,
                "offaddr" => $offaddr,
                "mobileno" => $mobileno,
                "landlineno" => $landlineno,
            ];

            $_SESSION["signup_data"] = $signup_data;

            /*  header("Location: ../index.php");
            die(); */
        }

        create_user($pdo, $firstname, $lastname, $username, $email, $resaddr, $offaddr, $mobileno, $landlineno, $pwd);

        header("Location: ../index.php?signup=success");
    } catch (PDOException $e) {
        die("Query Error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
