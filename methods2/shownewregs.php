<?php 
include "../connection/oopconnection.php";
    

    $sql = "SELECT * FROM users u, accounts a where a.status = 2 AND a.user_id = u.user_id";
   $res = $conn->query($sql) or die($conn->error);
    if($res->num_rows > 0){
echo " <table>
<tr>
<th>First name</th>
<th>Last name</th>
<th>Gender</th>
<th>Residence address</th>
<th>Official address</th>
<th>Landline No.</th>
<th>Mobile No.</th>
<th>Email</th>
<th>Action</th>

</tr>";
        while($row = $res->fetch_assoc()){
            echo "
           
            <tr>
              
                <td>".$row['Fname']."</td>
                <td>".$row['Lname']."</td>
                <td>".$row['Gender']."</td>
                <td>".$row['ResAdrs']."</td>
                <td>".$row['OfcAdrs']."</td>
                <td>".$row['LandlineNo']."</td>
                <td>".$row['MobileNo']."</td>
                <td>".$row['Email']."</td>
                <td>
                <button class='approvebtn' data-userid='".$row['user_id']."' onclick='approve(event)'>approve</button>
                <button class='denybtn'data-userid='".$row['user_id']."'onclick='deny(event)'>Deny</button>
                </td>
            </tr>
       ";
        }
      echo " </table>";
    
    }else{
        echo "no result found!";
    }
$conn->close();

?>