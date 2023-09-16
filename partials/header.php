<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
$_SESSION['isAdminMem'] = $isUser = ($currentPage == 'admins.php' || $currentPage == 'members.php');
if ($isUser) {


    $UID = $_SESSION['userid'] = $_GET["userid"];
    $username = $_SESSION['username'] = $_GET["username"];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <?php echo $isUser ? '<link rel="stylesheet" href="./css/cssloader.css">' : ''; ?>
    <link rel="stylesheet" href="./css/bookshover.css">


</head>

<body>
    <?php
    if ($isUser) {
        echo "
    <load class='containerloader'>
        <div class='loader'>
            <div class='loaditem'></div>
            <div class='loaditem'></div>
            <div class='loaditem'></div>
            <div class='loaditem'></div>
            <div class='loaditem'></div>
        </div>
    </load>
    ";
    }
    ?>

    <style>
        *,
        *::before,
        *::before {
            font-family: 'century gothic', sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #eee;
        }
    </style>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            </div>
        </div>
    </div>