
<?php
class UserCrud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUserData($id)
    {
        $response = [];
        $conn = $this->conn;
        // Create a prepared statement
        $sql = "SELECT ac.username,ac.type, us.* FROM accounts ac JOIN users us ON ac.user_id = us.user_id where ac.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Use prepared statement for profile image query
                $sqlImg = "SELECT * FROM profile_images WHERE user_id = ?;";
                $stmtImg = $conn->prepare($sqlImg);
                $stmtImg->bind_param("i", $id);
                $stmtImg->execute();
                $resultImg = $stmtImg->get_result();
                $stmtImg->close();

                if ($resultImg->num_rows > 0) {
                    while ($rowImg = $resultImg->fetch_assoc()) {
                        $profileData = $row;
                        if ($rowImg['status'] == 0) {
                            $filename = "./usersprofileimg/profile" . $id . "*";
                            $fileInfo = glob($filename);
                            $fileext = explode(".", $fileInfo[0]);
                            $fileActualExt1 = strtolower(end($fileext));
                            $profileData['profileImage'] = 'usersprofileimg/profile' . $id . '.' . $fileActualExt1;
                        } else {
                            $profileData['profileImage'] = 'usersprofileimg/profiledefault.png';
                        }

                        $response = $profileData;
                    }
                }
            }
        } else {
            $response['error'] = 'Account does not exist';
        }
        // Convert the response array to JSON and return it
        echo json_encode($response);
    }
    public function getAllUserData()
    {
        $response = [];
        $conn = $this->conn;
        // Create a prepared statement
        $sql = "SELECT * FROM users us,accounts ac where ac.user_id = us.user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $stmt->close();
        $id = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Use prepared statement for profile image query
                $sqlImg = "SELECT * FROM profile_images WHERE user_id = ?;";
                $stmtImg = $conn->prepare($sqlImg);
                $stmtImg->bind_param("i", $row['user_id']);
                $stmtImg->execute();
                $resultImg = $stmtImg->get_result();
                $stmtImg->close();

                if ($resultImg->num_rows > 0) {
                    while ($rowImg = $resultImg->fetch_assoc()) {
                        if ($rowImg['status'] == 0) {
                            $filename = "./usersprofileimg/profile" . $row['user_id'] . "*";
                            $fileInfo = glob($filename);
                            $fileext = explode(".", $fileInfo[0]);
                            $fileActualExt1 = strtolower(end($fileext));
                            $row['profileImage'] = 'usersprofileimg/profile' . $row['user_id'] . ".$fileActualExt1?" . mt_rand();
                        } else {
                            $row['profileImage'] = 'usersprofileimg/profiledefault.png';
                        }
                        $profileData[] = $row;
                        $response = $profileData;
                    }
                }
            }
        } else {
            $response['error'] = 'No Account found';
        }
        // Convert the response array to JSON and return it
        echo json_encode($response);
    }
    public function insertUser($data, $imagefile)
    {
        $conn = $this->conn;
        // Check if Username and Email already exists (similar to your existing code)
        $duplicateCheckUsername = $this->checkDuplicate('accounts', 'username', $data['accountData']['username']);
        $duplicateCheckEmail =  $this->checkDuplicate('users', 'Email', $data['userData']['Email']);
        $duplicateCheck = $duplicateCheckUsername  && $duplicateCheckEmail;
        if ($duplicateCheck) {
            // Username and Email  already exists, return an error
            $response['success'] = false;
            $response['message'] = 'Username and Email already exists. Please choose a different Username and Email.';
        } else if ($duplicateCheckEmail) {
            $response['success'] = false;
            $response['message'] = 'Email already exists. Please choose a different Email.';
        } else if ($duplicateCheckUsername) {
            $response['success'] = false;
            $response['message'] = 'Username already exists. Please choose a different Username.';
        } else {
            $userData = $data['userData'];
            $toUserResultId = $this->insertData('users', $userData);
            if ($toUserResultId) {
                $imageUploadResponse = $this->handleFileUpload($imagefile, $toUserResultId, $conn);
                $inserUserDataResponse = $this->insertUserQuery($toUserResultId, $data);

                if ($inserUserDataResponse && $imageUploadResponse['success']) {
                    // Member inserted successfully
                    $response['success'] = true;
                    $response['message'] = 'New Member added successfully.';
                } else {
                    // Error occurred during insertion
                    $response['success'] = false;
                    $response['message'] = "Error adding newMember. error_specified: " . $inserUserDataResponse;
                }
                if (!$imageUploadResponse['success']) {
                    // If image upload fails, update the main response
                    $response['success'] = false;
                    $response['message'] = 'Error uploading Member image. ' . $imageUploadResponse['message'];
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Error inserting usersData record into the database.';
            }
        }

        echo json_encode($response);
        exit;
    }
    public function insertUserQuery($id, $data)
    {
        date_default_timezone_set('Asia/Manila');
        $currdate = date("Y-m-d H:i:s");
        $data['accountData']['user_id'] = $id;
        $accountData = $data['accountData'];
        //inserting datas to db
        $toAccountResult = $this->insertData('accounts', $accountData);
        $toMembershipResult = $this->insertData('membership', array('user_id' => $id, 'DateJoined' => $currdate));

        if ($toAccountResult && $toMembershipResult) {
            return true;
        } else {
            return false;
        }
    }
    public function updatetUserQuery($id, $data)
    {
        date_default_timezone_set('Asia/Manila');
        $currdate = date("Y-m-d H:i:s");

        $accountData = $data['accountData'];
        $userData = $data['userData'];

        //inserting datas to db
        $updatingAccountResult = $this->updateData('accounts', $accountData, $id);
        $updatingUserResult = $this->updateData('users', $userData, $id);
        if ($updatingUserResult && $updatingAccountResult) {
            if ($updatingUserResult === 3 && $updatingAccountResult === 3 && !isset($accountData['password'])) {
                return 3;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    public function insertData($table, $data)
    {
        $fields = implode(", ", array_keys($data));
        $placeholders = str_repeat("?, ", count($data) - 1) . "?";
        $values = array_values($data);

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $res = true;
            $types = str_repeat("s", count($values));
            $stmt->bind_param($types, ...$values);
            $stmt->execute();
            if ($table == 'users') {
                $res = $stmt->insert_id;
            }
            $stmt->close();
            return $res;
        } else {
            $stmt->close();

            return false;
        }
    }
    public function updateUser($data, $imagefile)
    {
        $conn = $this->conn;
        $id = $data['id'];
        // Check if Username and Email already exists
        $duplicateCheckUsername = $this->isSameUserinput('accounts', array('username' => $data['accountData']['username']), $id) ? false : $this->checkDuplicate('accounts', 'username', $data['accountData']['username']);
        $duplicateCheckEmail = $this->isSameUserinput('users', array('Email' => $data['userData']['Email']), $id) ? false : $this->checkDuplicate('users', 'Email', $data['userData']['Email']);
        $duplicateCheck = $duplicateCheckUsername && $duplicateCheckEmail;

        if ($duplicateCheck) {
            // Username and Email  already exists, return an error
            $response['success'] = false;
            $response['message'] = 'Username and Email already exists. Please choose a different Username and Email.';
        } else if ($duplicateCheckEmail) {
            $response['success'] = false;
            $response['message'] = 'Email already exists. Please choose a different Email.';
        } else if ($duplicateCheckUsername) {
            $response['success'] = false;
            $response['message'] = 'Username already exists. Please choose a different Username.';
        } else {
            // updatetUserQuery
            $imagefile = !isset($_FILES['file']) ? false : $_FILES['file'];
            //handle image file upload
            $fileUploadResult = $this->handleFileUpload($imagefile, $id, $conn);
            // Call the updateMember function with the member and update data
            $updateResult = $this->updatetUserQuery($id, $data);

            if ($updateResult && $fileUploadResult['success']) {
                $response['success'] = true;
                $response['message'] = "Profile for User #$id has been successfully updated.";
                // Member updated successfully
                if ($updateResult === 3 && $fileUploadResult['success'] === 3) {
                    $response['message'] = array(
                        'title' => 'No Changes Detected',
                        'text' => "No changes were made to the profile for User #$id."
                    );
                }
            } else {
                // Error occurred during update
                $response['success'] = false;
                $response['message'] = "Failed to update your profile. Please try again later or contact support for assistance.";
            }
        }

        echo json_encode($response);
        exit;
    }
    public function isSameUserinput($tableName, $value, $id)
    {
        $clauseKey = key($value);
        $clauseValue = current($value);
        $sql = "SELECT * FROM $tableName WHERE user_id = ? AND $clauseKey = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $id, $clauseValue);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }


    public function updateData($table, $data, $id)
    {
        $updateFields = [];
        $updateParams = [];
        $paramTypes = '';
        // Construct the SET clause for the SQL query dynamically
        foreach ($data as $field => $value) {
            $updateFields[] = "`$field` = ?";
            $updateParams[] = $value;
            // Determine the data type and append to $paramTypes
            $paramTypes .=  $this->getTypeChar($$field = $value);
        }
        $setClause = implode(", ", $updateFields);
        array_push($updateParams, $id);
        $paramTypes .=  's';
        $stmt = $this->conn->prepare("UPDATE $table SET $setClause WHERE user_id = ?");
        $stmt->bind_param($paramTypes, ...$updateParams);
        if ($stmt->execute()) {
            $rowsAffected = $stmt->affected_rows;
            $stmt->close();
            if ($rowsAffected > 0) {
                // Changes were made
                return true;
            } else {
                // No changes were made
                return 3;
            }
        } else {
            $stmt->close();
            return false;
        }
    }

    //Function for deleting User to the database
    public function deleteUser($id)
    {
        $result = true;
        // Define the SQL queries
        $deleteUserQuery = "DELETE FROM users WHERE user_id = ?";
        $deleteAccountQuery = "DELETE FROM accounts WHERE user_id = ?";
        $deleteMembershipQuery = "DELETE FROM membership WHERE user_id = ?";
        $deleteProfileImgQuery = "DELETE FROM profile_images WHERE user_id = ?";

        // Prepare the statement for the user deletion
        $stmt = $this->conn->prepare($deleteUserQuery);
        $stmt->bind_param("s", $id);
        if (!$stmt->execute()) {
            $result = false;
        }
        $stmt->close();
        // Reuse the same statement for Account deletion
        $stmt = $this->conn->prepare($deleteAccountQuery);
        $stmt->bind_param("s", $id);
        if (!$stmt->execute()) {
            $result = false;
        }
        $stmt->close();
        // Reuse the same statement for Membership deletion
        $stmt = $this->conn->prepare($deleteMembershipQuery);
        $stmt->bind_param("s", $id);
        if (!$stmt->execute()) {
            $result = false;
        }
        $stmt->close();
        // Reuse the same statement for profile Image data in db deletion
        $stmt = $this->conn->prepare($deleteProfileImgQuery);
        $stmt->bind_param("s", $id);
        if (!$stmt->execute()) {
            $result = false;
        }

        $stmt->close();
        // Delete the User image file (multiple extensions)
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        foreach ($allowedExtensions as $extension) {
            $filePath = "./usersprofileimg/profile$id.$extension";
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    $result = false;
                }
            }
        }

        return $result;
    }
    // Function to handle image uploads
    function handleFileUpload($file, $id, $conn)
    {
        $response = [];

        if ($file && $file['name']) {
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];

            // Define the target directory and file name
            $uploadDirectory = "./usersprofileimg/";
            $fileNameNew = "profile" . $id . "." . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $fileDestination = $uploadDirectory . $fileNameNew;

            // Check if the file was successfully moved to the target directory
            if (move_uploaded_file($fileTmpName, $fileDestination)) {

                if ($this->isuserProfileImageExist($id) == false) {

                    $sql = "INSERT INTO profile_images(user_id, status) VALUES ('$id', 0)";
                    $result = mysqli_query($conn, $sql);
                } else {
                    // Assuming you have already retrieved $id and $status from somewhere
                    $sql = "UPDATE profile_images SET status = 0 WHERE user_id = '$id'";
                    $result = mysqli_query($conn, $sql);
                }
                if ($result) {
                    // Image record inserted successfully
                    $response['success'] = true;
                    $response['message'] = 'Image uploaded and record inserted successfully.,';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Error inserting image record into the database.';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Error moving the uploaded file to the destination directory.';
            }
        } else {
            //setting profile image to default in the database if doesnt have file uploaded
            $sqlImg = "SELECT * FROM profile_images WHERE user_id = '$id'";
            // Execute the SQL query
            $resultImg = mysqli_query($conn, $sqlImg);
            // Check if the profile is not exist set to default image
            if ($resultImg && mysqli_num_rows($resultImg) <= 0) {
                $sqlInsert = "INSERT INTO profile_images (user_id) VALUES ('$id')";
                $result = mysqli_query($conn, $sqlInsert);
                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'No file was uploaded. successfully set to Default image';
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error inserting member: " . mysqli_error($conn);
                }
            }
            // 'No file was uploaded. nothing happened'
            $response['success'] = 3;
        }

        return $response;
    }
    public function isuserProfileImageExist($id)
    {
        $sqlImg = "SELECT COUNT(*) AS count FROM profile_images WHERE user_id = ?";
        if ($stmt = $this->conn->prepare($sqlImg)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row['count'] > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function checkDuplicate($tableName, $columnName, $value)
    {
        $sql = "SELECT * FROM $tableName WHERE $columnName = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function getTypeChar($value)
    {
        if (is_int($value)) {
            return 'i'; // Integer
        } elseif (is_float($value)) {
            return 'd'; // Double (float)
        } else {
            return 's'; // String (default)
        }
    }
}
