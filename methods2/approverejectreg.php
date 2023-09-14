<?php 
include "../connection/oopconnection.php";
    if (isset($_POST['useridapprove'])) {
        date_default_timezone_set('Asia/Manila');
        $currdate = date("Y-m-d H:i:s");
        $userid= $_POST['useridapprove'];
        $sqlupdatestatus = "UPDATE accounts SET status = 0 WHERE user_id = $userid";
        $conn->query($sqlupdatestatus)or die($conn->error);


        $datejoined = "INSERT INTO membership(user_id,DateJoined) VALUES('$userid','$currdate')";
        $conn->query($datejoined)or die($conn->error);

        $select = "SELECT* FROM users WHERE user_id = $userid LIMIT 1";
        $res= $conn->query($select)or die($conn->error);
       $row = $res->fetch_assoc();
        echo " ".$row['Fname']." ".$row['Lname']." was approved";

    }
    if (isset($_POST['useriddeny'])) {
        $userid= $_POST['useriddeny'];
        $select = "SELECT* FROM users WHERE user_id = $userid LIMIT 1";
        $res= $conn->query($select)or die($conn->error);
       $row = $res->fetch_assoc();
     
        $delaccount = "DELETE FROM accounts WHERE user_id = $userid";
        $conn->query($delaccount)or die($conn->error);
        $deluser = "DELETE FROM users WHERE user_id = $userid";
        $conn->query($deluser)or die($conn->error);
        echo " ".$row['Fname']." ".$row['Lname']." was denied";
        
    }
$conn->close();

?>
