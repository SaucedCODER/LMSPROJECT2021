<?php 





include "connection/oopconnection.php";

    $sql3 = "SELECT * FROM accounts";
    $res1 = $conn->query($sql3);
    $row = $res1->num_rows;
    if ($row>0) {
    echo "
    <table>
    <tr>

    <th>Username</th>
    <th>Type</th>
    <th>Status</th>
    </tr>";
    while($rows = $res1->fetch_assoc()){
        if($rows['type'] !== 'ADMIN' ){

       
        if($rows['status']){
            $status = "Online";
        }else{
            $status = "OFfline";
        }
    echo " 
    <tr>
      <td>".$rows['username']."</td>
      <td>".$rows['type']."</td>
      <td>".$status."</td>
   
    </tr>
    
    ";
        }
    }
    echo "</table> <div>
    
    <button>Mark as Pro</button>
    </div>";
}else{
echo "No data has been found";
}
