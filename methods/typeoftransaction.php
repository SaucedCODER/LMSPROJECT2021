<?php
include "../connection/oopconnection.php";
    
date_default_timezone_set('Asia/Manila');
$currdate = date("Y-m-d H:i:s");

if(isset($_POST['selecteditemstobeprocess']) and isset($_POST['userid']) and isset($_POST['adminid'])) {


   $selecteditems = json_decode($_POST['selecteditemstobeprocess']) ;
   
    $id = $_POST['userid'];
    $admid = $_POST['adminid'];
    $adfull = "SELECT *, concat(Fname,' ',Lname) as fullname FROM users where user_id = $admid";
    $res12312 = $conn->query($adfull) or die($conn->error);
    $fetchres = $res12312->fetch_assoc();
    if (count($selecteditems) > 0) {
        // FOR PRINT OUTPUT !
      
        if (isset($_POST['typeoftrans'])) {
            $typetrans = $_POST['typeoftrans'];

        $sql = "SELECT *, r.TransactionNo as rtran FROM returntran r, users , borrowtran , book_collection bc
       where BTransactionNo IN (" . implode(",", $selecteditems) . ")  AND r.user_id = users.user_id AND bc.ISBN = r.ISBN
       AND borrowtran.TransactionNo = r.BTransactionNo ";

      $res = $conn->query($sql) or die($conn->error);


        $row = $res->num_rows;
if (!$row) {
 

}else{



    echo "<div class='reservetable recieptreturn' style='overflow:hidden;'>
    <div class='o'>Transaction Date:<strong>".$currdate."</strong></div>	
    <table id='rectable'>
    <tr>
        <th>Records of borrowed transactions (book-titled ISBN)</th>
 
        <th>Date Borrowed And transactions Number</th>
 
        <th>Type of transactions</th>
       
    
        <th>Overdue</th>
       
    </tr>";
    $totalpenshow = 0;
  while($rows= $res->fetch_assoc()){
      $name = $rows['Fname'];
      $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
      $totalpenalty = $totaloverdue * 20;
echo "
    <tr>
    <td>
    ".$rows['title']." ".$rows['ISBN']."
    </td>

        <td>".$rows['DateBorrowed']." B-".$rows['BTransactionNo']."</td>

        <td>".$typetrans."</td>

        <td style='color:blue;'>₱ ".$totalpenalty."</td>
 


    </tr>
    
    ";
    $totalpenshow += $totalpenalty;
  }
  
 $getmemname = "SELECT * FROM users where user_id = $id ";
 $resulta1 = $conn->query($getmemname);
 $showrow1=$resulta1->fetch_assoc();
 
 $getmemname1 = "SELECT * FROM users where user_id = $admid";
 $resulta2 = $conn->query($getmemname1);
  $showrow2=$resulta2->fetch_assoc();
 
  echo "</table>
  <h4 style=' margin-left:auto;margin-right:1em;color:#00f230;'>Total Penalties: ₱ $totalpenshow </h4>
<div style='border:2px solid black;margin-top:2em; width:100%; height:1px;'></div>
  
  <h3> Librarian: $showrow2[Fname] $showrow2[Lname]</h3>
  
<h3>  Borrower: $showrow1[Fname] $showrow1[Lname]</h3>
  <br>
  <h3>Librarian Signature:</h3>
  </div>

  <div class='btnprt'>
        <button data-adminidtransno='$id' onclick='cancelinprint(event)'>cancel</button>
        <button data-useridtrans='$id' onclick='window.print()'>PRINT</button>
  </div>
 

</div>
  ";
}
 }
echo "

";

// process the transaction 

        if (isset($_POST['typeoftrans'])) {
        $typetrans = $_POST['typeoftrans'];
            if ($typetrans == "returnonly") {
                 // insert to  history
                 $resinstohistory = $conn->query($sql) or die($conn->error);
                 while($rowhis = $resinstohistory->fetch_assoc()){
                  //with penalty
                  if($rowhis['paidpenalties'] < $rowhis['Overdue'] ){
                    $ssqla= "INSERT INTO `transaction_history` (`user_id`, `transactionDate`, `ISBN`, `BTransactionNo`, `TransactionType`, `admin_id`, `status`,`admin_fullname`) VALUES($id,'$currdate','$rowhis[ISBN]',$rowhis[BTransactionNo],'Return Only',$admid,'RETURN ONLY','$fetchres[fullname]')";
                    $conn->query($ssqla) or die($conn->error);
                  }else{
                    $ssqlb = "INSERT INTO `transaction_history` (`user_id`, `transactionDate`, `ISBN`, `BTransactionNo`, `TransactionType`, `admin_id`, `status`,`admin_fullname`) VALUES($id,'$currdate','$rowhis[ISBN]',$rowhis[BTransactionNo],'Return Only',$admid,'OK','$fetchres[fullname]')";
                    $conn->query($ssqlb) or die($conn->error);
                  }
                 }
            
                 //returnonly sets the isbookreturn to 0
                 $sqlro = "UPDATE borrowtran SET IsBookReturned = 0 where TransactionNo IN (" . implode(",", $selecteditems) . ")";
                 $conn->query($sqlro) or die($conn->error);
                
                 $rdate = "UPDATE returntran SET DateReturned = '$currdate' where BTransactionNo IN (" . implode(",", $selecteditems) . ")";

                 $conn->query($rdate) or die($conn->error);
                 $getisbn = "SELECT * FROM returntran WHERE BTransactionNo IN (" . implode(",", $selecteditems) . ")";
                 $isbns= $conn->query($getisbn) or die($conn->error);
           


                 while($rowboat= $isbns->fetch_assoc()){
     
                     //update stocks by returning logic haha!
                     $sqlcheckavail = "SELECT * FROM stocks where ISBN = '".$rowboat['ISBN']."'";
                     $resforcheck = $conn->query($sqlcheckavail) or die($conn->error);
                     $checkmate = $resforcheck->fetch_assoc();
                     $avai =  $checkmate['available'] + 1;
                     $lends = $checkmate['no_borrowed_books'] -1;
                     $sqlupdatestoc= "UPDATE stocks SET available =  $avai , no_borrowed_books=  $lends where ISBN ='".$rowboat['ISBN']."';";
                     $conn->query($sqlupdatestoc) or die($conn->error);
     
                 }
                 
           
            } else if ($typetrans == "payonly") {
                 // insert to  history
                 $resinstohistory1 = $conn->query($sql) or die($conn->error);
                 while($rowhis = $resinstohistory1->fetch_assoc()){
                  //not yet returned
                  if($rowhis['IsBookReturned'] == 1){
                    $ssqla= "INSERT INTO `transaction_history` (`user_id`, `transactionDate`, `ISBN`, `BTransactionNo`, `TransactionType`, `admin_id`, `status`,`admin_fullname`) VALUES($id,'$currdate','$rowhis[ISBN]',$rowhis[BTransactionNo],'Pay Only',$admid,'UNRETURNED','$fetchres[fullname]')";
                    $conn->query($ssqla) or die($conn->error);
                  }else{
                    $ssqlb = "INSERT INTO `transaction_history` (`user_id`, `transactionDate`, `ISBN`, `BTransactionNo`, `TransactionType`, `admin_id`, `status`,`admin_fullname`) VALUES($id,'$currdate','$rowhis[ISBN]',$rowhis[BTransactionNo],'Pay Only',$admid,'OK','$fetchres[fullname]')";
                    $conn->query($ssqlb) or die($conn->error);
                  }
                 }
                //payonly sets the paypenalties to value of overdue
                $sqlfetchoverdue = "SELECT * FROM returntran where BTransactionNo IN (" . implode(",", $selecteditems) . ")";
                $getoverdue = $conn->query($sqlfetchoverdue) or die($conn->error);
                if ($getoverdue->num_rows > 0) {
             
                $i = 0;
                    while ($row = $getoverdue->fetch_assoc()) {
                      
                            $sqlpo = "UPDATE returntran SET paidpenalties = " . $row['Overdue'] . " WHERE BTransactionNo = $selecteditems[$i]";
                            $conn->query($sqlpo) or die($conn->error);
                            $i++;
                    
                      
                    }
                }
              
            }else{
              //insert to history
              $resinstohistory2 = $conn->query($sql) or die($conn->error);
              while($rowhis = $resinstohistory2->fetch_assoc()){
                //OKAY STATUS
                 $ssqla= "INSERT INTO `transaction_history` (`user_id`, `transactionDate`, `ISBN`, `BTransactionNo`, `TransactionType`, `admin_id`, `status`,`admin_fullname`) VALUES($id,'$currdate',$rowhis[ISBN],$rowhis[BTransactionNo],'Return and Pay',$admid,'OK','$fetchres[fullname]')";
                 $conn->query($ssqla) or die($conn->error);
               }



                //payonly and return sets status to ok
                $sqlok = "UPDATE returntran SET Status = 'OK' WHERE BTransactionNo IN (" . implode(",", $selecteditems) . ")";
                $conn->query($sqlok) or die($conn->error);
                

                //check if the book is returned or not for tblstock
                $checkrorn = "SELECT * FROM borrowtran WHERE TransactionNo IN (" . implode(",", $selecteditems) . ")";
            $resulta = $conn->query($checkrorn) or die($conn->error);
              if($resulta->num_rows > 0){

                while($hanay= $resulta->fetch_assoc()){
                  
                    if ($hanay['IsBookReturned']== 1) {
                  
                          $getisbn = "SELECT * FROM returntran WHERE BTransactionNo = '".$hanay['TransactionNo']."';";
                          $isbns= $conn->query($getisbn) or die($conn->error);
                    
                          while($rowboat= $isbns->fetch_assoc()){
              
                              //update stocks by returning logic haha!
                              $sqlcheckavail = "SELECT * FROM stocks where ISBN = '".$rowboat['ISBN']."'";
                              $resforcheck = $conn->query($sqlcheckavail) or die($conn->error);
                              $checkmate = $resforcheck->fetch_assoc();
                              $avai =  $checkmate['available'] + 1;
                              $lends = $checkmate['no_borrowed_books'] -1;
                              $sqlupdatestoc= "UPDATE stocks SET available =  $avai , no_borrowed_books=  $lends where ISBN ='".$rowboat['ISBN']."';";
                              $conn->query($sqlupdatestoc) or die($conn->error);
              
                          }
                        }
                    }

              }
            }
  

          
        }

       
    }
    $conn->close();
        
    include "updaterecords.php";
    include "../connection/oopconnection.php";
    $paying = "SELECT * FROM returntran;";
    $whopay = $conn->query($paying);
    while($road = $whopay->fetch_assoc()){
    if($road['Status'] == 'OK'){
      //insert to transaction history all oks
      $sqlsavetohistory= "INSERT INTO settledtrans SELECT * FROM returntran WHERE BTransactionNo = ".$road['BTransactionNo']."";
      $conn->query($sqlsavetohistory);

    $del ="DELETE FROM borrowtran WHERE TransactionNo = ".$road['BTransactionNo']."";
    $conn->query($del);
  $upstatus ="DELETE FROM returntran WHERE BTransactionNo = ".$road['BTransactionNo']."";
    $conn->query($upstatus);
  
  }
  }
  $conn->close();
}
