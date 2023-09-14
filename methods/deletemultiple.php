<?php 

  include "../connection/oopconnection.php";



  if(isset($_POST['deleteitemsfromcart'])){
  
      $items = json_decode($_POST['deleteitemsfromcart']) ;
      
         $sql = "DELETE FROM cart WHERE cart_id IN (".implode(",", $items ) . ")";
         $conn->query($sql) ;
         $conn->close();

  include 'getbookfromcart.php';

  }
  else if((isset($_POST['delitemfromreserve']) AND isset($_POST['userid']))){

    $items = json_decode($_POST['delitemfromreserve']);
      
    $sql = "DELETE FROM reserve_record WHERE reserve_id IN (".implode(",", $items ) . ")";
    $conn->query($sql) ;
    $conn->close();
  include 'filterUserReserve.php';
  } 



 
?>