<?php
include "../connection/oopconnection.php";

if (isset($_POST['category'])) {

  $link = $_POST['category'];

  $array = array();

  $query = "SELECT * FROM book_collection join stocks on category = '$link' and book_collection.ISBN = stocks.ISBN";

  $res = $conn->query($query);
  while ($row = $res->fetch_assoc()) {
    $array[] = $row;
  }
  include "../rendersviaphp/renderbook.php";
  show_data($array);
}
