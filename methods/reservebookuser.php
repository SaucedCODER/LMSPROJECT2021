<?php 
include "../connection/oopconnection.php";
if (isset($_POST['userid'])) {


    date_default_timezone_set('Asia/Manila');
    $currdate = date("Y-m-d H:i:s");
    $id = $_POST['userid'];

            
    $sql2 = "SELECT sum(IsBookReturned) as unreturnedbook FROM borrowtran  where user_id = $id";
    $res2 = $conn->query($sql2);
    $row2 = $res2->fetch_assoc();
    $canbeborrowed = 3 - $row2['unreturnedbook'];
    if($canbeborrowed){

      
            $updsql = "UPDATE cart c SET reserve_date = '$currdate' where c.user_id = $id";
            $conn->query($updsql) or die($conn->error);

            $sql = "INSERT INTO reserve_record(user_id,ISBN,date_reserve) SELECT user_id,ISBN,reserve_date FROM cart where cart.user_id = $id";
            $conn->query($sql) or die($conn->error);

            $getrows = "Select * FROM cart where user_id = $id";
            $res = $conn->query($getrows);
            $reservemess= $res->num_rows;

            $del = "DELETE FROM cart where user_id = $id";
            $conn->query($del) or die($conn->error);

            $conn->close();
            include 'getbookfromcart.php';
  
 
    }else{
        echo "You exceed the maximum no. of books to be borrowed!";    

    }
    
}


?>