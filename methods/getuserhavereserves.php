
<?php
include "../connection/procconnection.php";
if ((isset($_POST['table']) and isset($_POST['getfield']))) {
	# code...

	$table = $_POST['table'];
	$getfield = $_POST['getfield'];

	if ($table == 'reserve_record') {
		$sql = "SELECT *,r.user_id as user,
			count(r.user_id) AS items 
			FROM $table r 
			left JOIN users a
			ON a.user_id = r.user_id
			GROUP BY r.user_id  
			ORDER BY $getfield DESC;";
	} else {
		$sql = "SELECT *,a.user_id as user, count(c.user_id) as notif
			FROM users a JOIN accounts b ON b.type = 'STUDENT' 
            AND a.user_id = b.user_id left JOIN borrowtran c ON c.user_id = a.user_id group by c.user_id;";

		// $sql = "SELECT *,a.user_id as user
		// FROM users a,accounts b where b.type = 'STUDENT' AND a.user_id = b.user_id
		// ORDER BY Fname DESC;";
	}


	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		echo "<div class='main-container'>";
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['user'];
			$sqlImg = "SELECT * FROM `profile_images` WHERE `user_id`='$id';";
			$resultImg = mysqli_query($conn, $sqlImg);
			while ($rowImg = mysqli_fetch_assoc($resultImg)) {
				if ($table == "reserve_record") {


					echo "<div onclick='uniquserreserve(event)'  data-userid='" . $row['user_id'] . "' class='container'> ";
					if ($rowImg['status'] == 0) {
						$filename = "../usersprofileimg/profile" . $id . "*";
						$fileInfo = glob($filename);
						$fileext = explode(".", $fileInfo[0]);
						$fileActualExt1 = strtolower(end($fileext));

						echo "<img data-imgsrc='usersprofileimg/profile" . $id . ".$fileActualExt1' src='usersprofileimg/profile" . $id . ".$fileActualExt1' >";
						echo "<p>" . $row['Lname'] . " <strong>| ID:</strong> " . $row['user'] . "</p>";
					} else {
						echo "<img data-imgsrc='usersprofileimg/profiledefault.png' src='usersprofileimg/profiledefault.png'>";
						echo "<p>" . $row['Lname'] . " <strong>| ID:</strong> " . $row['user'] . "</p>";
					}

					echo " </div>";
				} else {

					echo "<div class='container user-item' onclick='uniquserbtran(event)' data-userid='" . $row['user_id'] . "'>";
					if ($rowImg['status'] == 0) {
						$filename = "../usersprofileimg/profile" . $id . "*";
						$fileInfo = glob($filename);
						$fileext = explode(".", $fileInfo[0]);
						$fileActualExt1 = strtolower(end($fileext));

						echo "<img data-imgsrc='usersprofileimg/profile" . $id . ".$fileActualExt1' src='usersprofileimg/profile" . $id . ".$fileActualExt1' class='img-fluid rounded-circle user-image'>";
					} else {
						echo "<img data-imgsrc='usersprofileimg/profiledefault.png' src='usersprofileimg/profiledefault.png' class='img-fluid rounded-circle user-image'>";
					}

					echo "<p class='text-center'>" . $row['Lname'] . " <strong>| ID:</strong> " . $row['user'] . "</p>";

					if ($row['notif'] > 0) {
						echo "<span style='color:white;margin-left:auto;margin-right:.4em;background:red;border-radius:50px;width:26px;text-align:center;'>" . $row['notif'] . "+</span>";
					}

					echo "</div>";
				}
			}
		}
		echo "</div>";
	} else {

		if ($table == "reserve_record") {

			echo "There are no reserves yet! ;";

			# code...
		} else {

			echo "There's no unsettled transactions yet! ;";
		}
	}
	mysqli_close($conn);
}
?>