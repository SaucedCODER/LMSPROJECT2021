<?php

declare(strict_types=1);

function empty_firstname(string $firstname)
{
    if (empty($firstname)) {
        return true;
    } else {
        return false;
    }
}

function empty_lastname(string $lastname)
{
    if (empty($lastname)) {
        return true;
    } else {
        return false;
    }
}

function empty_resaddr(string $resaddr)
{
    if (empty($resaddr)) {
        return true;
    } else {
        return false;
    }
}

function empty_offaddr(string $offaddr)
{
    if (empty($offaddr)) {
        return true;
    } else {
        return false;
    }
}

function empty_mobileno(string $mobileno)
{
    if (empty($mobileno)) {
        return true;
    } else {
        return false;
    }
}

function empty_landlineno(string $landlineno)
{
    if (empty($landlineno)) {
        return true;
    } else {
        return false;
    }
}

function empty_gender(string $gender)
{
    if (empty($gender)) {
        return true;
    } else {
        return false;
    }
}

function empty_pwd(string $pwd, string $confirmpwd)
{
    if (empty($pwd) || empty($confirmpwd)) {
        return true;
    } else {
        return false;
    }
}

function username_taken(object $pdo, string $username)
{
    if (get_username($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function email_invalid(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function email_registered(object $pdo, string $email)
{
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $firstname, string $lastname, string $username, string $email, string $resaddr, string $offaddr, string $mobileno, string $landlineno, string $pwd)
{
    set_user($pdo, $firstname, $lastname, $username, $email, $resaddr, $offaddr, $mobileno, $landlineno, $pwd);
}
