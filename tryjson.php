<?php 
include "connection/procconnection.php";

function fetch_data()
{
  global $conn;
  $query = "SELECT * from book_collection";
  $exec = mysqli_query($conn, $query);
  if (mysqli_num_rows($exec) > 0) {
    $row = mysqli_fetch_all($exec, MYSQLI_ASSOC);
    return $row;
  } else {
    return $row = [];
  }
  $conn->close();
}
echo json_encode(fetch_data());
?>