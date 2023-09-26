<?php

include "connection/oopconnection.php";


if (!isset($_POST['search'])) {
} else {
  $search = $conn->real_escape_string($_POST['search']);
  $select = $_POST['select'];
  $category =  $conn->real_escape_string($_POST['category']);
  if ($category == 'All') {
    $stb = "SELECT * FROM book_collection WHERE $select LIKE '%" . $search . "%' limit 5;";
  } else {
    $stb = "SELECT * FROM book_collection WHERE $select LIKE '%" . $search . "%' AND category = '$category' limit 5;";
  }


  $res = $conn->query($stb) or die("wala laman");
  $rows = $res->num_rows;

  if ($rows > 0) {
    echo "<h4 padding:.4em; style='color:black;background:white;margin:0; '>Findings..</h4>";
    while ($row = $res->fetch_assoc()) {
      echo "<div class='itemsearch'data-listid='" . $row["$select"] . "'>" . $row["$select"] . "</div>";
    }
  }
}
$conn->close();
