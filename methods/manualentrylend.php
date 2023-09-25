<?php
include "../connection/oopconnection.php";
session_start();

$response = array(); // Create an empty array to store the response data
if ((!empty($_POST['lendtouserid']) || !empty($_POST['userid']))) {
  // Get the user ID and admin ID
  $userid = $_POST['lendtouserid'];
  $adminid = $_POST['userid'];

  // Validate user ID
  if (!is_numeric($userid) || $userid <= 0) {
    $response['error'] = 'Invalid user ID';
    $response['data'] = null;
  } else {
    // Query to fetch user details
    $result = $conn->query("SELECT *, CONCAT(Fname, ' ', Lname) as fn, CONCAT('Student ID: ', username) as stud FROM users a, accounts b WHERE a.user_id = $userid AND b.user_id = a.user_id");

    if ($result) {
      if ($result->num_rows > 0) {
        $userDetails = array(); // Create an array to store user details

        while ($rowss = $result->fetch_assoc()) {
          $userDetails['full_name'] = $rowss['fn'];
          $userDetails['student_id'] = $rowss['stud'];
        }

        // Get the number of books in the cart
        $cartCountResult = $conn->query("SELECT COUNT(*) as cart_count FROM cart WHERE user_id = $adminid");
        $cartCount = $cartCountResult->fetch_assoc()['cart_count'];

        $response['error'] = null; // No error
        $response['data'] = $userDetails; // Set user details as data
        $response['cart_count'] = $cartCount; //Set the number of books in cart
        $response['toLendId'] = $userid; // 
      } else {
        $response['error'] = 'User not found'; // Set an error message
        $response['data'] = null; // No data
      }
    } else {
      $response['error'] = 'Database error'; // Set an error message
      $response['data'] = null; // No data
    }
  }
} else {
  $response['error'] = 'No user System ID provided'; // Set an error message
  $response['data'] = null; // No data
}

// Convert the response array to JSON and return it
echo json_encode($response);
