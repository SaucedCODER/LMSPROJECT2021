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
    echo "No results found...<div class='datasr'style='visibility:hidden;' data-statusr='off'>value</div>";
}else{
    echo "<div class='reservetable'>
    <table>
    <tr>
  
 
        <th>ISBN</th>
 
        <th>BorrowedDate</th>
       
        <th>Status</th>
        <th>view book</th>
        <th>Overdue Penalty</th>
     
      
    </tr>";
    $totalpo = 0;
  while($rows= $res->fetch_assoc()){
      $name = $rows['Fname'];
      $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
      $totalpenalty = $totaloverdue * 20;
      $totalpo += $totalpenalty;
echo "
    <tr>
  
        <td>".$rows['ISBN']."</td>

        <td>".$rows['DateBorrowed']."</td>
        <td>".$rows['Status']."</td>
        <td><a href='#'>view</a></td></td>
        <td style='color:blue;'> ₱ ".$totalpenalty."</td>
 
     

    </tr>
    
    ";

  }
  
 
  echo "
  
  </table>
  <h3 style='color:red;'> TOTAL PENALTY :  ₱ ".$totalpo."</h3>
  </div>
 



  ";
}
}
$conn->close();
?>

