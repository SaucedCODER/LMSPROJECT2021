<?php 
  include "../connection/oopconnection.php";
  session_start();


  if((!empty($_POST['lendtouserid']) || !empty($_POST['userid']))){
    //id's
      $userid = $_POST['lendtouserid'];
        $adminid = $_POST['userid'];
    
        $cont = 0;


        $result= $conn->query("SELECT * FROM users where user_id = $userid");
   
        if($result){

            if($rows = $result->num_rows){

                if(isset($_POST['confirm'])){

                    $status = $_POST['confirm'];

                    if (strlen($status) > 0) {
                    
                      $sql2 = "SELECT sum(IsBookReturned) as unreturnedbook FROM borrowtran  where user_id = $userid";
                      $res2 = $conn->query($sql2);
                      $row2 = $res2->fetch_assoc();
                      $canbeborrowed = 3 - $row2['unreturnedbook'];
                      if($canbeborrowed){
                       
                          //no of books in cart maximum of 3 - 
                          $sql3 = " SELECT count(user_id) as noofbooksincart FROM cart where user_id = $adminid";
                          $res3 = $conn->query($sql3);
                          $row3 = $res3->fetch_assoc();
                           $row3['noofbooksincart'];
                          if($canbeborrowed >= $row3['noofbooksincart'] ){

                  while($rowss = $result->fetch_assoc()){
                    //get current time and due time
                    date_default_timezone_set('Asia/Manila');
                    $currdate = date("Y-m-d H:i:s");
                    $currdate1 = new DateTime($currdate);
                    $Adddays = 1;
                    $duedate = $currdate1->modify("+{$Adddays} day");
                    $stamp = $duedate->format('Y-m-d H:i:s');

                    $sql= "SELECT * FROM cart WHERE user_id = $adminid";
                    $res = $conn->query($sql);
                    $rowed = $res->num_rows;
                    
                        while($row = $res->fetch_assoc()){
                          $sql11 = "SELECT * FROM stocks where ISBN ='".$row['ISBN']."'";
                          $res11 = $conn->query($sql11);
                          $row11 = $res11->fetch_assoc();
                         
                          if ($row11['available']){

                              $sqlins = "INSERT INTO borrowtran(user_id,ISBN,DateBorrowed,due_date)
                              VALUES(".$userid.",'".$row['ISBN']."','".$currdate."','".$stamp."')";
                              $conn->query($sqlins) or die($conn->error);
                              
                             $cont++;
                              //update stocks by borrowing logic haha!
                              $sqlcheckavail = "SELECT * FROM stocks where ISBN = '".$row['ISBN']."'";
                              $resforcheck = $conn->query($sqlcheckavail) or die($conn->error);
                              $checkmate = $resforcheck->fetch_assoc();
                              $avai =  $checkmate['available'] - 1;
                             $lends = $checkmate['no_borrowed_books'] + 1;
                            $sqlupdatestoc= "UPDATE stocks SET available =  $avai , no_borrowed_books=  $lends where ISBN ='".$row['ISBN']."';";
                              $conn->query($sqlupdatestoc) or die($conn->error);

                             
                          }else{
                            
                            echo "error: OUT OF STOCK! book title: ".$row['book_title']." ISBN: ".$row['ISBN']."";
                        
                          }
                        
                        }
                        if ($cont) {
                          echo "<h3 style='color:yellowgreen;'>You Lend ".$cont." / ".$rowed." book/s to ".$rowss['Fname']." ".$rowss['Lname'].".</h3>";
                        }
                      //insert the borrowtransactions in return transaction
                      $sqlr = "SELECT * FROM borrowtran where DateBorrowed = '".$currdate."' AND user_id = $userid;";
                        $resu = $conn->query($sqlr);
                        $rowwww = $resu->num_rows;

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

                    $conn->query("DELETE FROM cart where user_id = $adminid");
                   
                
                  }
            $error = "*";
          }else{
            
            echo "User can only borrow ".$canbeborrowed." books..";
          }
          }else{
            echo "User exceeds the maximum no. of books to be borrowed";
          }
            $conn->close();

        }

        }
          }else{
            $error = "Invalid id";
          }

        }
      
        include 'getbookfromcart.php';
        }
     
      



?>
