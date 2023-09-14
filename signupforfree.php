<?php
if (isset($_POST['submit-signup'])) {
	include "connection/procconnection.php";

	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$pwdrepeat = mysqli_real_escape_string($conn, $_POST['pwd-repeat']);
	$Gender = mysqli_real_escape_string($conn, $_POST['gender']);
	$resad = mysqli_real_escape_string($conn, $_POST['resad']);
	$Mobile_no = mysqli_real_escape_string($conn, $_POST['Mobile_no']);
	$Landlineno = mysqli_real_escape_string($conn, $_POST['Landlineno']);
	$OfficialAdress = mysqli_real_escape_string($conn, $_POST['OfficialAdress']);

	if (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
		$uid = "";
		header("Location: registrationform.php?first=$first&last=$last&uid=$uid&email=$email&gender=$gender&Mobile_no=$Mobile_no&Landlineno=$Landlineno&OfficialAdress=$OfficialAdress&resad=$resad&pwd=$pwd&pwd-repeat=$pwdrepeat&error=Invalidsid");
		exit();
	} else if ($pwd !== $pwdrepeat) {

		header("Location: registrationform.php?first=$first&last=$last&uid=$uid&email=$email&gender=$gender&Mobile_no=$Mobile_no&Landlineno=$Landlineno&OfficialAdress=$OfficialAdress&resad=$resad&error=pwdnotmatch");
		exit();
	} else {

		$sql = "SELECT username FROM accounts WHERE username=?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: registrationform.php?sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $uid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if ($resultCheck > 0) {

				echo "<script>alert('Error: Student ID is already taken!');window.location='registrationform.php?error=Student Id is already taken!'</script>";
				exit();
			} else {
				$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
				$sql = "INSERT INTO users (Fname, Lname,Email,ResAdrs,OfcAdrs,LandlineNo,MobileNo,Gender) 
                    VALUES ('$first', '$last','$email','$resad','$OfficialAdress',' $Landlineno','$Mobile_no','$Gender')";
				mysqli_query($conn, $sql);

				$select = "SELECT * FROM users ORDER BY user_id DESC LIMIT 1";
				$res = mysqli_query($conn, $select);
				$rows = $res->fetch_assoc();
				$usersID = $rows['user_id'];
				$sql1 = "INSERT INTO accounts(user_id,username,password,status) 
                    VALUES (" . $rows['user_id'] . ",'$uid','$pwd',2)";
				mysqli_query($conn, $sql1) or die("error");


				echo $sql2 = "SELECT * FROM accounts join users WHERE accounts.user_id='$usersID' AND users.user_id='$usersID' ";
				$result = mysqli_query($conn, $sql2);

				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {

						$sql = "INSERT INTO profile_images(user_id, status) VALUES ('$usersID', 1);";
						mysqli_query($conn, $sql) or die("d na nalagay sa profile images");

						echo "<script>alert('please consult the librarian for the approval of your registration!');window.location='home.php?signup_success'</script>";

						exit();
					}
				} else {
					echo "You have an error!";
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
} else {
	header("Location: /");
	exit();
}
