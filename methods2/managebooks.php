<?php
include "../connection/oopconnection.php";

// Create an array to store book data
$books = array();

$table = $conn->query("SELECT * FROM stocks st, book_collection bc where st.ISBN = bc.ISBN ORDER BY Title desc ") or die($conn->error);
while ($row = $table->fetch_assoc()) {
   $isbnn = $row['ISBN'];
   $sqlImg = "SELECT * FROM book_image where ISBN = '$isbnn'";
   $resultImg = mysqli_query($conn, $sqlImg);
   $rowImg = mysqli_fetch_assoc($resultImg);

   // Determine the image URL based on the status
   if ($rowImg['status'] == 0) {
      $filename = "../booksimg/book" . $row['ISBN'] . "*";
      $fileInfo = glob($filename);
      $fileext = explode(".", $fileInfo[0]);
      $fileActualExt1 = strtolower(end($fileext));
      $imageURL = "booksimg/book" . $row['ISBN'] . ".$fileActualExt1?" . mt_rand();
   } else {
      $imageURL = "booksimg/bookdefault.png";
   }

   // Create an associative array for each book, including image and status data
   $book = array(
      "ISBN" => $row['ISBN'],
      "Title" => $row['title'],
      "Author" => $row['author'],
      "ImageURL" => $imageURL // Include the image URL in the array
   );

   // Add book data to the array
   $books[] = $book;
}

// Encode the array as JSON
echo json_encode($books);

$conn->close();
