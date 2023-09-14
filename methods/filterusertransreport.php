<?php 
 include "../connection/oopconnection.php";
if(isset($_POST['userid'])){
  $paying = "SELECT * FROM returntran;";
  $whopay = $conn->query($paying);
  while($road = $whopay->fetch_assoc()){
  if($road['Status'] == 'OK'){
          
  $del ="DELETE FROM borrowtran WHERE TransactionNo = ".$road['BTransactionNo']."";
  $conn->query($del);
$upstatus ="DELETE FROM returntran WHERE BTransactionNo = ".$road['BTransactionNo']."";
  $conn->query($upstatus);

}
}

$id = $_POST['userid'];


$sql = "SELECT * FROM borrowtran, users , returntran 
where borrowtran.user_id = '$id' AND users.user_id = '$id' AND returntran.BTransactionNo = borrowtran.TransactionNo 
ORDER BY DateBorrowed DESC;";

$res = $conn->query($sql) or die("failed");
$row = $res->num_rows;
if (!$row) {
    echo "This user has no transaction reports<div class='datasr'style='visibility:hidden;' data-statusr='off'>value</div>";
}else{
    echo "<div class='reservetable'>
    <table>
    <tr>
        <th>Select</th>
 
        <th>ISBN</th>
 
        <th>BorrowedDate</th>
       
    
        <th>Overdue Penalty</th>
        <th>Status</th>
        <th>View Book</th>
    </tr>";
  while($rows= $res->fetch_assoc()){
      $name = $rows['Fname'];
      $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
      $totalpenalty = $totaloverdue * 20;
echo "
    <tr>
    <td>

    <input type='checkbox' class='selectitemtransno' id='transno".$rows['BTransactionNo'] . "' value='" . $rows['BTransactionNo']. "'>
    
    </td>

        <td>".$rows['ISBN']."</td>

        <td>".$rows['DateBorrowed']."</td>

        <td style='color:blue;'>₱ ".$totalpenalty."</td>
        <td>".$rows['Status']."</td>
        <td><a href='#' id='view' onclick='viewbookev(event)' data-bookuniq='".$rows['ISBN']."'>view</a></td></td>

    </tr>
    
    ";

  }
  
 
  echo "</table></div>
  <hr>
  <h4 style='display:block;margin-bottom:2px;'>Transaction type:</h4>
  <div class='optionsreturn'>

  <select name='option' id='option'>
    <option value='returnonly'>return only</option>
    <option value='returnpay only'>return and pay only</option>
    <option value='payonly'>pay only</option>
</select>

<button data-useridtrans='$id' onclick='selectaddshow(event)'>add selected items</button>

</div>
  ";
}
}
$conn->close();
?>
