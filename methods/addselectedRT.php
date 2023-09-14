<?php
include "../connection/oopconnection.php";
if (isset($_POST['selecteditemstobeprocess']) and isset($_POST['userid'])) {

  $selecteditems = json_decode($_POST['selecteditemstobeprocess']);

  $id = $_POST['userid'];

  if (count($selecteditems) > 0) {

    if (isset($_POST['typeoftrans'])) {

      $typetrans = $_POST['typeoftrans'];

   
     
     $sql = "SELECT * FROM returntran r, users , borrowtran
     where BTransactionNo IN (" . implode(",", $selecteditems) . ") 
     AND  r.user_id = users.user_id AND borrowtran.TransactionNo = r.BTransactionNo ";
      $res = $conn->query($sql) or die($conn->error);
      
      $row = $res->num_rows;
      if (!$row) {
        echo "wwala lamn";
      } else {
        $trigger = 0;
      
    
        while ($check = $res->fetch_assoc()) {

        if($typetrans == "payonly" AND $check['Overdue'] === $check['paidpenalties']){
          //check the balance get paidpenalties and overdue
          $trigger+=1;
          echo "<div style='visibility:hidden;' id='triger' data-trigger='$trigger'>warning: transaction type not match!</div>";
        die();
  
        }else if($typetrans == "returnonly" AND $check['IsBookReturned'] == 0){
           //check the status of the book if returned or not
           $trigger+=1;
           echo "<div style='visibility:hidden;' id='triger' data-trigger='$trigger'>warning: transaction type not match!!</div>";
          die();

        }else if($typetrans == "returnpay only"){
          
          if($check['IsBookReturned'] == 0 OR $check['Overdue'] === $check['paidpenalties']){
            $trigger+=1;
            echo "<div style='visibility:hidden;' id='triger' data-trigger='$trigger'>warning: transaction type not match!!!</div>";
            die();
          }
          
        }
        
      }
        echo "
        <div class='reservetable modalasi'>
        <div style='visibility:hidden;' id='triger' data-trigger='$trigger'></div>
    <table>
    <tr>
        <th>Select</th>
 
        <th>ISBN</th>
 
        <th>BorrowedDate</th>
       
    
        <th>Overdue Penalty</th>
        <th>Type of Transaction</th>
    </tr>";
  
     $res1 = $conn->query($sql) or die($conn->error);

        while ($rows = $res1->fetch_assoc()) {
          $name = $rows['Fname'];
          $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
          $totalpenalty = $totaloverdue * 20;
          echo "
    <tr>
    <td>
    <input type='checkbox' class='selectitemtransnoADRT' id='transno" . $rows['BTransactionNo'] . "' value='" . $rows['BTransactionNo'] . "'>
    </td>

        <td>" . $rows['ISBN'] . "</td>

        <td>" . $rows['DateBorrowed'] . "</td>

        <td style='color:blue;'>₱ ".$totalpenalty."</td>
        <td>" . $typetrans . "</td>


    </tr>
    
    ";
        }


        echo "</table>
  <hr>

  <button onclick='canceladdselected()'>cancel</button>
  <button onclick='removelistRTMODAL()'>remove selected items</button>
<button data-useridtrans='$id' onclick='selectproccesstransacs(event)'>Process listed Items</button>

</div>
  ";
      }
    }
  }
  $conn->close();
}
