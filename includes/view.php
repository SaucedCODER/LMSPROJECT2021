<?php

declare(strict_types=1);

function signup_input()
{
    if (isset($_SESSION["signup_data"]["firstname"]) && isset($_SESSION["errors_signup"]["empty_firstname"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="firstname" placeholder="First Name"><br>
        <small>' . $_SESSION["errors_signup"]["empty_firstname"] . '</small><br>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="firstname" placeholder="First Name">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["lastname"]) && isset($_SESSION["errors_signup"]["empty_lastname"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="lastname" placeholder="Last Name"><br>
        <small>' . $_SESSION["errors_signup"]["empty_lastname"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["resaddr"]) && isset($_SESSION["errors_signup"]["empty_resaddr"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="resaddr" placeholder="Residence Address"><br>
        <small>' . $_SESSION["errors_signup"]["empty_resaddr"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="resaddr" placeholder="Residence Address">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["offaddr"]) && isset($_SESSION["errors_signup"]["empty_offaddr"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="offaddr" placeholder="Official Address"><br>
        <small>' . $_SESSION["errors_signup"]["empty_offaddr"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="offaddr" placeholder="Official Address">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["mobileno"]) && isset($_SESSION["errors_signup"]["empty_mobileno"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="mobileno" placeholder="Mobile No."><br>
        <small>' . $_SESSION["errors_signup"]["empty_mobileno"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="mobileno" placeholder="Mobile No.">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["landlineno"]) && isset($_SESSION["errors_signup"]["empty_landlineno"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="landlineno" placeholder="Landline No."><br>
        <small>' . $_SESSION["errors_signup"]["empty_landlineno"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="landlineno" placeholder="Landline No.">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["gender"]) && isset($_SESSION["errors_signup"]["empty_gender"])) {
        echo '<div class="form-group">
        <label>Gender:</label>
        <input type="radio" name="male" value="Male"> Male
        <input type="radio" name="female" value="Female"> Female<br>
        <small>' . $_SESSION["errors_signup"]["empty_gender"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <label>Gender:</label>
        <input type="radio" name="male" value="Male"> Male
        <input type="radio" name="female" value="Female"> Female
    </div>';
    }

    if (isset($_SESSION["signup_data"]["studid"]) && isset($_SESSION["errors_signup"]["empty_studid"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="studid" placeholder="Student IDe"><br>
        <small>' . $_SESSION["errors_signup"]["empty_studid"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="studid" placeholder="Student ID">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["pwd"]) && isset($_SESSION["signup_data"]["confirmpwd"]) && isset($_SESSION["errors_signup"]["pwd"])) {
        echo '<div class="form-group">
        <input type="password" class="form-control" name="pwd" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="confirmpwd" placeholder="Confirm Password"><br>
        <small>' . $_SESSION["errors_signup"]["empty_pwd"] . '</small>
    </div>';
    } else {
        echo '<div class="form-group">
        <input type="password" class="form-control" name="pwd" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="confirmpwd" placeholder="Confirm Password">
    </div>';
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_taken"]) && !isset($_SESSION["errors_signup"]["email_invalid"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="email" placeholder="G-mail" value="' . $_SESSION["signup_data"]["email"] . '"></div>';
    } else if (isset($_SESSION["signup_data"]["email"]) && isset($_SESSION["errors_signup"]["email_invalid"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="email" placeholder="G-mail"><br>
        <small>' . $_SESSION["errors_signup"]["email_invalid"] . '</small>';
    } else if (isset($_SESSION["signup_data"]["email"]) && isset($_SESSION["errors_signup"]["email_taken"])) {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="email" placeholder="G-mail"><br>
        <small>' . $_SESSION["errors_signup"]["email_taken"] . '</small>';
    } else {
        echo '<div class="form-group">
        <input type="text" class="form-control" name="email" placeholder="G-mail">
    </div>';
    }
}

/* function checkSignupErrors()
{
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];

        echo "<br>";

        foreach ($errors as $error) {
            echo "<p class='form-error'>" . $error . "</p>";
        }

        unset($_SESSION["errors_signup"]);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p class='form-success'>Signup successful</p>";
    }
}
 */