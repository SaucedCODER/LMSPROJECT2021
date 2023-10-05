<?php

declare(strict_types=1);

function signup_input()
{
    // firstname
    if (isset($_SESSION["signup_data"]["firstname"]) && isset($_SESSION["errors_signup"]["empty_firstname"])) {
        echo '<input type="text" name="firstname" placeholder="First Name"><br>
        <small>' . $_SESSION["errors_signup"]["empty_firstname"] . '</small><br>';
    } else {
        echo '<input type="text" name="firstname" placeholder="First Name"><br>';
    }

    // lastname
    if (isset($_SESSION["signup_data"]["lastname"]) && isset($_SESSION["errors_signup"]["empty_lastname"])) {
        echo '<input type="text" name="lastname" placeholder="Last Name"><br>
        <small>' . $_SESSION["errors_signup"]["empty_lastname"] . '</small><br>';
    } else {
        echo '<input type="text" name="firstname" placeholder="Last Name"><br>';
    }

    // username
    if (isset($_SESSION["signup_data"]["username"]) && isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username">
        <small>' . $_SESSION["errors_signup"]["username_taken"] . '</small><br>';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    // email
    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_taken"]) && !isset($_SESSION["errors_signup"]["email_invalid"])) {
        echo '<input type="text" name="email" placeholder="G-mail" value="' . $_SESSION["signup_data"]["email"] . '';
    } else if (isset($_SESSION["signup_data"]["email"]) && isset($_SESSION["errors_signup"]["email_invalid"])) {
        echo '<input type="text" name="email" placeholder="G-mail"><br>
        <small>' . $_SESSION["errors_signup"]["email_invalid"] . '</small>';
    } else if (isset($_SESSION["signup_data"]["email"]) && isset($_SESSION["errors_signup"]["email_taken"])) {
        echo '<input type="text" name="email" placeholder="G-mail"><br>
        <small>' . $_SESSION["errors_signup"]["email_taken"] . '</small>';
    } else {
        echo '<input type="text" name="email" placeholder="G-mail">';
    }

    // Residence Address
    if (isset($_SESSION["signup_data"]["resaddr"]) && isset($_SESSION["errors_signup"]["empty_resaddr"])) {
        echo '<input type="text" name="resaddr" placeholder="Residence Address"><br>
        <small>' . $_SESSION["errors_signup"]["empty_resaddr"] . '</small>';
    } else {
        echo '<input type="text" name="resaddr" placeholder="Residence Address">';
    }

    // Official Address
    if (isset($_SESSION["signup_data"]["offaddr"]) && isset($_SESSION["errors_signup"]["empty_offaddr"])) {
        echo '<input type="text" name="offaddr" placeholder="Official Address"><br>
        <small>' . $_SESSION["errors_signup"]["empty_offaddr"] . '</small>';
    } else {
        echo '<input type="text" name="offaddr" placeholder="Official Address">';
    }

    // Mobile Number
    if (isset($_SESSION["signup_data"]["mobileno"]) && isset($_SESSION["errors_signup"]["empty_mobileno"])) {
        echo '<input type="text" name="mobileno" placeholder="Mobile No."><br>
        <small>' . $_SESSION["errors_signup"]["empty_mobileno"] . '</small>';
    } else {
        echo '<input type="text" name="mobileno" placeholder="Mobile No.">';
    }

    // Landline Number
    if (isset($_SESSION["signup_data"]["landlineno"]) && isset($_SESSION["errors_signup"]["empty_landlineno"])) {
        echo '<input type="text" name="landlineno" placeholder="Landline No."><br>
        <small>' . $_SESSION["errors_signup"]["empty_landlineno"] . '</small>';
    } else {
        echo '<input type="text" name="landlineno" placeholder="Landline No.">';
    }

    // Password
    echo '<input type="password" name="pwd" placeholder="Password">';
}
