
<?php

class UserData
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserData($id)
    {
        $response = [];
        $conn = $this->db;
        // Create a prepared statement
        $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1;";
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
                        $profileData = [
                            'sysId' => $id,
                            'Fname' => $row['Fname'],
                            'status' => $rowImg['status'],
                        ];
                        if ($rowImg['status'] == 0) {
                            $filename = "../usersprofileimg/profile" . $id . "*";
                            $fileInfo = glob($filename);
                            $fileext = explode(".", $fileInfo[0]);
                            $fileActualExt1 = strtolower(end($fileext));
                            $profileData['profileImage'] = 'usersprofileimg/profile' . $id . '.' . $fileActualExt1;
                        } else {
                            $profileData['profileImage'] = 'usersprofileimg/profiledefault.jpg';
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
}
