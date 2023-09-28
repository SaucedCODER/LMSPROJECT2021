<?php
include "../connection/oopconnection.php";

$response = array(); // Initialize an array to hold the response data

$sql = "SELECT * FROM users u, accounts a WHERE a.status = 2 AND a.user_id = u.user_id";
$res = $conn->query($sql) or die($conn->error);

if ($res->num_rows > 0) {
    $data = array(); // Initialize an array to hold the result data

    while ($row = $res->fetch_assoc()) {
        // Push each row as an associative array into the data array
        $data[] = array(
            'Fname' => $row['Fname'],
            'Lname' => $row['Lname'],
            'Gender' => $row['Gender'],
            'ResAdrs' => $row['ResAdrs'],
            'OfcAdrs' => $row['OfcAdrs'],
            'LandlineNo' => $row['LandlineNo'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email'],
            'user_id' => $row['user_id'],
        );
    }

    // Set the data array in the response
    $response['data'] = $data;
    $response['message'] = 'Data retrieved successfully'; // Optional message

    // Encode the response array to JSON and echo it
    echo json_encode($response);
} else {
    // No results found
    $response['message'] = 'No pending approvals at the moment.';
    echo json_encode($response);
}

$conn->close();
