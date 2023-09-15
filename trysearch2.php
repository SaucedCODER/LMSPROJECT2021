<?php
include "connection/oopconnection.php";

if (isset($_POST['search'])) {

  $search = $conn->real_escape_string($_POST['search']);
  $select = $_POST['select'];
  $array = array();
  $category = $conn->real_escape_string($_POST['category']);
  if ($category == 'All') {
    $query = "SELECT * FROM book_collection join stocks on book_collection.$select LIKE '%" . $search . "%' AND book_collection.ISBN = stocks.ISBN LIMIT 10;";
  } else {
    $query = "SELECT * FROM book_collection join stocks on book_collection.$select LIKE '%" . $search . "%' AND book_collection.ISBN = stocks.ISBN AND book_collection.category = '$category' LIMIT 10;";
  }
  $res = $conn->query($query);

  while ($row = $res->fetch_assoc()) {
    $array[] = $row;
  }
  $conn->close();
  include "./rendersviaphp/renderbook.php";
  show_data($array);
}
