<?php

include "../connection/procconnection.php";
//show profile image and username only

if (isset($_POST['userid'])) {

    $id = $_POST['userid'];
    $sql = "SELECT * FROM users where user_id = $id LIMIT 1;";
    $result = mysqli_query($conn, $sql) or die("d gumana");

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $sqlImg = "SELECT * FROM profile_images where user_id = $id;";
            $resultImg = mysqli_query($conn, $sqlImg) or die("mali");

            if (mysqli_num_rows($resultImg) > 0) {


                while ($rowImg = mysqli_fetch_assoc($resultImg)) {

                    echo "<div data-userid='" . $id . "' class='containerprofile'>";
                    if ($rowImg['status'] == 0) {
                        $filename = "../usersprofileimg/profile" . $id . "*";
                        $fileInfo = glob($filename);
                        $fileext = explode(".", $fileInfo[0]);
                        $fileActualExt1 = strtolower(end($fileext));
                        echo "<img src='usersprofileimg/profile" . $id . ".$fileActualExt1?" . mt_rand() . "'>";
                    } else {

                        echo "<img src='usersprofileimg/profiledefault.jpg'>";
                    }
                    echo "<p>" . $row['Fname'] . " SystemId:" . $id . "</p>";
                    echo "</div>";
                }
            }
        }
    } else {
        echo "Account does'nt exist!";
    }
}
// show detailts
if (isset($_POST['useridshowdetails'])) {

    $id = $_POST['useridshowdetails'];
    $sql = "SELECT * FROM users s,accounts a,membership m where s.user_id = $id and a.user_id = s.user_id and m.user_id = s.user_id limit 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $sqlImg = "SELECT * FROM profile_images where user_id = $id;";
            $resultImg = mysqli_query($conn, $sqlImg);
            while ($rowImg = mysqli_fetch_assoc($resultImg)) {

                if ($rowImg['status'] == 0) {
                    $filename = "../usersprofileimg/profile" . $id . "*";

                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileActualExt1 = strtolower(end($fileext));
                    echo "<img src='usersprofileimg/profile" . $id . ".$fileActualExt1?" . mt_rand() . "'>";
                } else {
                    echo "<img src='usersprofileimg/profiledefault.jpg'>";
                }
                echo "<div class='containerdet'>";
                echo "<p style='grid-column:1 / -1'>DATE JOINED:" . $row['DateJoined'] . "</p>";
                echo "<p><strong>First name: </strong> " . $row['Fname'] . "</p>";
                echo "<p><strong>Last name: </strong> " . $row['Lname'] . "</p>";
                echo "<p><strong>ID No: </strong> " . $row['user_id'] . "</p>";
                echo "<p> <strong>Residence address: </strong>" . $row['ResAdrs'] . "</p>";
                echo "<p> <strong>Official address: </strong>" . $row['OfcAdrs'] . "</p>";
                echo "<p> <strong>Land Line No: </strong>" . $row['LandlineNo'] . "</p>";
                echo "<p> <strong>Mobile No: </strong>" . $row['MobileNo'] . "</p>";
                echo "<p> <strong>Gender: </strong>" . $row['Gender'] . "</p>";


                echo "</div>";
                echo "
        <div class='updatebtncontainer'>
        <button class='closebtnforupdateprofile' onclick='closemodal()'>CLOSE</button>
        <button class='editbtn' data-userid='" . $row['user_id'] . "' onclick='editmyacc(event)'>EDIT</button>
        </div>
        ";
            }
        }
    } else {
        echo "Account does'nt exist!";
    }
}
if (isset($_POST['useriduserupdate'])) {
    $id = $_POST['useriduserupdate'];

    $sql = "SELECT * FROM users s,accounts a where s.user_id = $id and a.user_id = s.user_id  limit 1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['user_id'];
            $sqlImg = "SELECT * FROM profile_images where user_id = $id;";
            $resultImg = mysqli_query($conn, $sqlImg);
            while ($rowImg = mysqli_fetch_assoc($resultImg)) {

                if ($rowImg['status'] == 0) {
                    $filename = "../usersprofileimg/profile" . $id . "*";

                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileActualExt1 = strtolower(end($fileext));
                    echo "<img id='chimg' src='usersprofileimg/profile" . $id . ".$fileActualExt1?" . mt_rand() . "'>";
                } else {
                    echo "<img id='chimg' src='usersprofileimg/profiledefault.jpg'>";
                }
                echo "
                    <input id='filedata' type='file' onchange='readURL(this)' name='file'>
              
              ";
                echo "<div class='containerdet'>";
                echo "<p style='grid-column:1 / -1'>YOUR BASIC INFORMATIONS</p>";
                echo "<p><strong>First name:</strong>  <input type='text' id='Fname'autocomplete='off'value='" . $row['Fname'] . "'></p>";
                echo "<p><strong>Last name:</strong>  <input type='text' id='Lname'autocomplete='off' value='" . $row['Lname'] . "'></p>";
                echo "<p> <strong>Residence address:</strong> <input type='text' id='ResAdrs'autocomplete='off' value='" . $row['ResAdrs'] . "'></p>";
                echo "<p> <strong>Official address:</strong> <input type='text' id='OfcAdrs'autocomplete='off' value='" . $row['OfcAdrs'] . "'></p>";
                echo "<p> <strong>Land Line No:</strong> <input type='text' id='LandlineNo'autocomplete='off' value='" . $row['LandlineNo'] . "'></p>";
                echo "<p> <strong>Mobile No:</strong> <input type='text' id='MobileNo'autocomplete='off' value='" . $row['MobileNo'] . "'></p>";

                echo "<p style='grid-column:1 / -1'>YOUR ACCOUNT</p>";
                echo "<p> <strong>Username</strong> <input type='text' id='username'autocomplete='off' value='" . $row['username'] . "'></p>";
                echo "<p> <strong>Password:</strong> <input type='password' id='password'autocomplete='off' value='" . $row['password'] . "'> </p>
                   <p style='display:flex;grid-column:2/-1;padding-top:5px;'> <input style='display:flex;width:30px;margin:0;'onclick='toggleshowpass()' type='checkbox'>Show password</p>
                    ";
                echo "</div>";
                echo "
                    <div class='updatebtncontainer'>
        
            <button class='editbtn' data-userid='" . $row['user_id'] . "' onclick='doneediting(event)'>DONE</button>
          
            </div>
        ";
            }
        }
    } else {
        echo "Account does'nt exist!";
    }
}

if (isset($_POST['accid'])) {

    $id = $_POST['accid'];

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $resid = $_POST['resid'];
    $OfcAdrs = $_POST['ofcAdrs'];
    $landlineN = $_POST['landlineNo'];
    $MobileN = $_POST['MobileNo'];
    $username =  $_POST['username'];
    $password =  $_POST['password'];

    $updateinfo = "UPDATE users SET Fname = '$fname',Lname = '$lname',ResAdrs = '$resid',OfcAdrs = '$OfcAdrs',
      LandlineNo = '$landlineN',MobileNo = '$MobileN' WHERE user_id = $id;";
    $sqlin = mysqli_query($conn, $updateinfo);
    $sqlupdate = "UPDATE accounts SET username = '$username',password = '$password' where  user_id = $id;";
    $sqlacc = mysqli_query($conn, $sqlupdate);
    if ($sqlin and $sqlacc) {
        echo "Updated!";
    } else {
        echo "failed";
    }
}

mysqli_close($conn);
