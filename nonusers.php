<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
</head>

<body>
    <h1>Access Denied</h1>
    <p>You do not have permission to access this page. Please log in or contact the administrator for assistance.</p>
    <?php
    if (isset($_SESSION['username'])) {
        echo '<p><a href="logout.php">Logout</a></p>';
    }
    ?>
</body>

</html>