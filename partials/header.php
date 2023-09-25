<?php
session_start();
if (!isset($_SESSION['userRole'])) {
    $_SESSION['userRole'] = 'index.php';
}

$isUser = ($_SESSION['userRole'] == 'admins.php' || $_SESSION['userRole'] == 'members.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Library Management System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" />
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <!-- Date  Picker -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- dropzone file uploads -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <?php echo $isUser ? '<link rel="stylesheet" href="./css/cssloader.css">
     <link rel="stylesheet" href="./css/tables.css">'

        : ''; ?>
    <link rel="stylesheet" href="./css/bookshover.css">
    <link rel="stylesheet" href="./css/adjustBootstrap.css">

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

        .swal2-popup {
            font-size: 14px !important;
            width: 400px !important;
        }
    </style>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            </div>
        </div>
    </div>