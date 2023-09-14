<?php 
include "../connection/oopconnection.php";

if(isset($_POST['userid'])){
    $id = $_POST['userid'];
    $countsuccess = 0;
     //get current time and due time
    date_default_timezone_set('Asia/Manila');
    $currdate = date("Y-m-d H:i:s");
    $currdate1 = new DateTime($currdate);
    $Adddays = 1;

    $duedate = $currdate1->modify("+{$Adddays} day");
    
    $stamp = $duedate->format('Y-m-d H:i:s');

    $sql = "SELECT * FROM reserve_record where user_id = $id";
    $res = $conn->query($sql);

    $sql2 = "SELECT sum(IsBookReturned) as unreturnedbook FROM borrowtran  where user_id = $id";
    $res2 = $conn->query($sql2);
    $row2 = $res2->fetch_assoc();
    $canbeborrowed = 3 - $row2['unreturnedbook'];
    if($canbeborrowed){
     
        //no of books in cart maximum of 3 - 
        $sql3 = " SELECT count(user_id) as noofbooksincart FROM reserve_record where user_id = $id";
        $res3 = $conn->query($sql3);
        $row3 = $res3->fetch_assoc();
         $row3['noofbooksincart'];
        if($canbeborrowed >= $row3['noofbooksincart'] ){
        
    while($row = $res->fetch_assoc()){
        
        $sql11 = "SELECT * FROM stocks where ISBN ='".$row['ISBN']."'";
        $res11 = $conn->query($sql11);
        $row11 = $res11->fetch_assoc();
        if ($row11['available']) {
            # code...
            $countsuccess++;
           $sqlins = "INSERT INTO borrowtran(user_id,ISBN,DateBorrowed,due_date)
            VALUES(".$row['user_id'].",'".$row['ISBN']."','".$currdate."','".$stamp."')";
            $conn->query($sqlins) or die($conn->error);

            //update stocks by borrowing logic haha!

            $sqlcheckavail = "SELECT * FROM stocks where ISBN = '".$row['ISBN']."'";
            $resforcheck = $conn->query($sqlcheckavail) or die($conn->error);
            $checkmate = $resforcheck->fetch_assoc();
            $avai =  $checkmate['available'] - 1;
            $lends = $checkmate['no_borrowed_books'] + 1 ;
            $sqlupdatestoc= "UPDATE stocks SET available =  $avai , no_borrowed_books=  $lends where ISBN ='".$row['ISBN']."';";
            $conn->query($sqlupdatestoc) or die($conn->error);


        }else{
            echo "<p style='color:red;'>System message: out of stock, BOOK ISBN: ".$row['ISBN']." transaction failed </p>";

      
        }
    }

          //insert the borrowtransactions in return transaction 
            
          $sqlr = "SELECT * FROM borrowtran where DateBorrowed = '".$currdate."' AND user_id = $id;";
          $resu = $conn->query($sqlr);
  
          if($resu->num_rows > 0){
          
              while($rowed= $resu->fetch_assoc()){    
              //unreturn
              $cTime = new DateTime($currdate);
              $edittime = new DateTime("".$rowed['DateBorrowed']."");
                  $overdue =$cTime->diff($edittime);
                  $diffInDays  = $overdue->d;
  
  
              $sqlinss="INSERT INTO returntran(user_id,ISBN,BTransactionNo,Overdue,Status)
              VALUE(".$rowed['user_id'].",'".$rowed['ISBN']."',".$rowed['TransactionNo'].",'".$diffInDays."','UNRETURNED')";
              $conn->query($sqlinss) or die($conn->error);
          }
  
      }
      if($countsuccess > 0){
        echo "<p class='resmessage' style='color:#09ff00;'>System message: ID no: ".$id." successfully borrowed ".$countsuccess." book/s</p>";
      }
     
      $conn->query("DELETE FROM reserve_record where user_id = $id");
      $conn->close();
       
  }
  else {
    echo "<p class='resmessage'style='color:#ff9900;'>System message: User can only borrow ".$canbeborrowed." books..</p>";

}
 
}else{
    echo "<p class='resmessage'style='color:#ff9900;'>System message: User exceeds the maximum no. of books to be borrowed</p>";
    
}


   
    
    include 'filterUserReserve.php';
}
?>
