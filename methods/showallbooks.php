<?php


function fetch_data()
{
  include "../connection/oopconnection.php";

  $query = "SELECT * from book_collection JOIN stocks ON book_collection.ISBN = stocks.ISBN;";

  $stmt = $conn->prepare($query);
  $stmt->execute();
  $rows = $stmt->get_result();
  if ($rows->num_rows) {
    while ($data = $rows->fetch_assoc()) {
      $arraydata[] = $data;
    }
    return $arraydata;
  } else {
    return 0;
  }


  $stmt->close();
  $conn->close();
}
include "../rendersviaphp/renderbook.php";
$fetchData = fetch_data();
if ($fetchData) {
  echo show_data($fetchData);
} else {
  echo "no books found!";
}
