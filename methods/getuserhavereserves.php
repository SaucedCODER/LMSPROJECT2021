
<?php
include "../connection/procconnection.php";
if ((isset($_POST['table']) && isset($_POST['getfield']))) {
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
            AND a.user_id = b.user_id left JOIN returntran c ON c.user_id = a.user_id where c.Status != 'OK' group by c.user_id;";

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
				} else if ($row['notif'] > 0) {

					echo "
					<li class='list-group-item list-group-item-action d-flex justify-content-end gap-2 align-items-center' data-userid='" . $row['user_id'] . "'  onclick='uniquserbtran(event)'>

					<div class='user-avatar'>
					";
					if ($rowImg['status'] == 0) {
						$filename = "../usersprofileimg/profile" . $id . "*";
						$fileInfo = glob($filename);
						$fileext = explode(".", $fileInfo[0]);
						$fileActualExt1 = strtolower(end($fileext));

						echo "
							<img height='30' width='30'data-imgsrc='usersprofileimg/profile" . $id . ".$fileActualExt1' src='usersprofileimg/profile" . $id . ".$fileActualExt1' alt='User Profile' class='user-profile-img img-fluid rounded-circle border-1 border-primary-subtle' />
							";
					} else {
						echo "
							<img height='30' width='30'data-imgsrc='usersprofileimg/profiledefault.png' src='usersprofileimg/profiledefault.png' alt='User Profile' class='user-profile-img img-fluid rounded-circle border-1 border-primary-subtle' />
							";
					}
					echo "</div>";

					echo "
					<div class='user-details d-flex flex-fill flex-column'>
						<span class='user-id'>#$row[user]</span>
						<span class='user-name d-flex flex-row align-items-center'><small>$row[Fname] $row[Lname]</small> <span class='dots'></span><small></small>
						</span>
					</div>
					";

					if ($row['notif'] > 0) {
						echo "
						<span class='badge bg-secondary rounded-pill'>$row[notif]<i class='bi bi-hourglass'></i></span>";
					}

					echo "</li>";
				}
			}
		}
	} else {

		if ($table == "reserve_record") {

			echo "There are no reserves yet! ;";

			# code...
		} else {

			echo "No Users with Unsettled Transactions Found!";
		}
	}
	mysqli_close($conn);
}
?>