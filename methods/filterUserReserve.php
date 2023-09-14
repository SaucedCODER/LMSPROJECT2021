<?php 
 include "../connection/oopconnection.php";
if(isset($_POST['userid'])){
$id = $_POST['userid'];
$stat = 0;

$sql = "SELECT * FROM reserve_record JOIN users ON reserve_record.user_id = '$id' AND users.user_id = '$id' ORDER BY date_reserve DESC";

$res = $conn->query($sql) or die("failed");
$row = $res->num_rows;
if (!$row) {
    echo "This user has no reservations <div class='datas'style='visibility:hidden;' data-status='off'>value</div>";
}else{
    echo "<div class='reservetable'>
    <table>
    <tr>
        <th>Select</th>
 
        <th>ISBN</th>
 
        <th>reserve_date</th>
       
    
        <th>View Book</th>
    </tr>";
  while($rows= $res->fetch_assoc()){
      $name = $rows['Fname'];
echo "
    <tr>
    <td>

    <input type='checkbox' class='selectitemreserve' id='reserveid".$rows['reserve_id'] . "' value='" . $rows['reserve_id'] . "'>
    
    </td>

        <td>".$rows['ISBN']."</td>

        <td>".$rows['date_reserve']."</td>
        <td><a href='#' id='view' onclick='viewbookev(event)'data-bookuniq='".$rows['ISBN']."'>view</a></td></td>

    </tr>
    
    ";
    $sql11 = "SELECT * FROM stocks where ISBN ='".$rows['ISBN']."'";
$res11 = $conn->query($sql11);
$row11 = $res11->fetch_assoc();

if ($row11['available']){
 
}else{
  $stat++;
}

  }
  $gbooks = $row-$stat;
 
  echo "</table></div>
  <div class='buttondel'>
  <hr>
<button data-ressuserid='$id' onclick='delselectedinreservation(event)'>Remove Selected Items</button>

<button data-lenduserid='$id' data-bstatus='$gbooks' onclick='lendonreservation(event)'>Lend listed Items</button>
</div>
  ";
}
}
$conn->close();
?>

