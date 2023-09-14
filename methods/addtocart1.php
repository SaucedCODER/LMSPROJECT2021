<?php 
session_start();
include '../connection/oopconnection.php';

$title;
$ISBN;




if(isset( $_POST['bookid'])){

  $memid= $_POST['userid'];
  //getting the title and ISBN using book_id

   $bid = $_POST['bookid']; 
   $sql = "SELECT * FROM book_collection WHERE ISBN = '$bid'";
  $res = $conn->query($sql);
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
       $title = $conn->real_escape_string($row['title']);
      $ISBN = $conn->real_escape_string($row['ISBN']);

      $sql11 = "SELECT * FROM stocks where ISBN ='".$ISBN."'";
      $res11 = $conn->query($sql11);
      $row11 = $res11->fetch_assoc();
     
      if ($row11['available']){
      //no of unreturned books
      $sql2 = "SELECT sum(IsBookReturned) as unreturnedbook FROM borrowtran  where user_id = $memid";
      $res2 = $conn->query($sql2);
      $row2 = $res2->fetch_assoc();
      $canbeborrowed = 3 - $row2['unreturnedbook'];
       $canbeborrowed;
      if($canbeborrowed){
        
  
      //no of books in cart maximum of 3 - 
      $sql3 = " SELECT count(user_id) as noofbooksincart FROM cart where user_id = $memid";
      $res3 = $conn->query($sql3);
      $row3 = $res3->fetch_assoc();
    
      if($canbeborrowed > $row3['noofbooksincart'] ){

        $sql4 = " SELECT count(user_id) as noofbooksincart FROM reserve_record where user_id = $memid";
      $res4 = $conn->query($sql4);
      $row4 = $res4->fetch_assoc();
      $canbeborrowed2 = 3 - $row4['noofbooksincart'];
     
      if($canbeborrowed2 > $row3['noofbooksincart'] ){

        if( $canbeborrowed > $row4['noofbooksincart']){
        
              //inserting the title isbn and member ID
              $sql24="INSERT INTO cart(user_id,ISBN,book_title)
              values('$memid','$ISBN','$title')
              ";
              $conn->query($sql24);
              echo "<span class='currtitle' style='display:none;'>".$row['title']."</span>";

              include 'getbookfromcart.php';

        }else{
          echo "<span class='currerror' style='display:none;'>You exceed the maximum no. of books to be reserved</span>";
        }
      }else{
        echo "<span class='currerror' style='display:none;'>You exceed the maximum no. of books to be reserved</span>";
      }

      }else{
        echo "<span class='currerror' style='display:none;'>You exceed the maximum no. of books to be reserved</span>";
      }

     
      
      }else{
         echo "<span class='currerror' style='display:none;'>You exceed the maximum no. of books to be borrowed</span>";
      }

    
  }else{
    echo "<span class='currerror' style='display:none;'>The book is not available!</span>";
  }
    }
}else{
    echo "wala laman";
}


  // <label for='reserveid".$rows['id_reserve']."'></label>
