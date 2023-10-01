<?php 
 include "../connection/procconnection.php";
if((isset($_POST['searchthisuser'])&isset($_POST['table']))){
$table = $_POST['table'];
$find = $_POST['searchthisuser'];

$sql = "SELECT * , r.user_id as user,count(r.user_id) as notif FROM $table r 
JOIN users a
ON a.user_id = r.user_id AND r.user_id LIKE '%".$find."%' 
GROUP BY r.user_id;";


$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			echo "<div class='main-container'>";
			while ($row = mysqli_fetch_assoc($result)) {
				$id = $row['user'];
				$sqlImg = "SELECT * FROM `profile_images` WHERE `user_id`='$id';";
				$resultImg = mysqli_query($conn, $sqlImg);
				while ($rowImg = mysqli_fetch_assoc($resultImg)) {
					if($table == "reserve_record"){

					
						echo "<div onclick='uniquserreserve(event)'  data-userid='".$row['user_id']."' class='container'> ";
							if ($rowImg['status'] == 0) {
								 $filename = "../usersprofileimg/profile".$id."*";
								$fileInfo = glob($filename);
								$fileext = explode(".", $fileInfo[0]);
								$fileActualExt1 = strtolower(end($fileext)); 

									
	
								echo "<img data-imgsrc='usersprofileimg/profile".$id.".$fileActualExt1' src='usersprofileimg/profile".$id.".$fileActualExt1' >";
								echo "<p>".$row['Lname']."<strong>| ID:</strong> ".$row['user']."</p>";
							}
							else {
								echo "<img data-imgsrc='usersprofileimg/profiledefault.png' src='usersprofileimg/profiledefault.png'>";
								echo "<p>".$row['Lname']." <strong>| ID:</strong>".$row['user']."</p>";
							}
					
						echo "</div>";
					
					}else{
							
						echo "<div onclick='uniquserbtran(event)'  data-userid='".$row['user_id']."' class='container'> ";
							if ($rowImg['status'] == 0) {
								 $filename = "../usersprofileimg/profile".$id."*";
								$fileInfo = glob($filename);
								$fileext = explode(".", $fileInfo[0]);
								$fileActualExt1 = strtolower(end($fileext)); 

									
	
								echo "<img data-imgsrc='usersprofileimg/profile".$id.".$fileActualExt1' src='usersprofileimg/profile".$id.".$fileActualExt1' >";
								echo "<p>".$row['Lname']."<strong>| ID:</strong> ".$row['user']."</p>";
							}
							else {
								echo "<img data-imgsrc='usersprofileimg/profiledefault.png' src='usersprofileimg/profiledefault.png'>";
								echo "<p>".$row['Lname']."<strong>| ID:</strong> ".$row['user']."</p>";
							}
							if ($row['notif'] > 0 ) {
								echo " <span style='color:white;margin-left:auto;margin-right:.4em;background:red;border-radius:50px;width:26px;text-align:center;'>".$row['notif']."+</span>";
							   
						   }
							   
							   
							   
							   echo "</div>";
		   
	
					}
	
				}
			
			}
			echo "</div>";
		}
		else {
			echo "no user found! ;";
		}
	

}
mysqli_close($conn);
