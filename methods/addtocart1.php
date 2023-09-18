<?php
session_start();
include '../connection/oopconnection.php';

// Initialize variables
$title = null;
$ISBN = null;

if (isset($_POST['bookid'])) {
  $memid = $_POST['userid'];
  $bid = $_POST['bookid'];

  // Get book details using book_id
  $sql = "SELECT * FROM book_collection WHERE ISBN = '$bid'";
  $res = $conn->query($sql);

  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $title = $conn->real_escape_string($row['title']);
    $ISBN = $conn->real_escape_string($row['ISBN']);

    // Check if the book is available
    $sql11 = "SELECT * FROM stocks WHERE ISBN = '$ISBN'";
    $res11 = $conn->query($sql11);
    $row11 = $res11->fetch_assoc();

    if ($row11['available']) {
      // Calculate the number of unreturned books
      $sql2 = "SELECT SUM(IsBookReturned) AS unreturnedbook FROM borrowtran WHERE user_id = $memid";
      $res2 = $conn->query($sql2);
      $row2 = $res2->fetch_assoc();
      $canbeborrowed = 3 - $row2['unreturnedbook'];

      if ($canbeborrowed) {
        // Calculate the number of books in the cart
        $sql3 = "SELECT COUNT(user_id) AS noofbooksincart FROM cart WHERE user_id = $memid";
        $res3 = $conn->query($sql3);
        $row3 = $res3->fetch_assoc();

        if ($canbeborrowed > $row3['noofbooksincart']) {
          // Calculate the number of books in reserve
          $sql4 = "SELECT COUNT(user_id) AS noofbooksincart FROM reserve_record WHERE user_id = $memid";
          $res4 = $conn->query($sql4);
          $row4 = $res4->fetch_assoc();
          $canbeborrowed2 = 3 - $row4['noofbooksincart'];

          if ($canbeborrowed2 > $row3['noofbooksincart']) {
            if ($canbeborrowed > $row4['noofbooksincart']) {
              // Insert book into the cart
              $sql24 = "INSERT INTO cart(user_id, ISBN, book_title)
                                      VALUES ('$memid', '$ISBN', '$title')";
              $conn->query($sql24);
              echo "<span class='currtitle' style='display:none;'>" . $row['title'] . "</span>";

              // include 'getbookfromcart.php';
            } else {
              echo "<span class='currerror' style='display:none;'>You exceed the maximum number of books to be reserved</span>";
            }
          } else {
            echo "<span class='currerror' style='display:none;'>You exceed the maximum number of books to be reserved</span>";
          }
        } else {
          echo "<span class='currerror' style='display:none;'>You exceed the maximum number of books to be borrowed</span>";
        }
      } else {
        echo "<span class='currerror' style='display:none;'>You exceed the maximum number of books to be borrowed</span>";
      }
    } else {
      echo "<span class='currerror' style='display:none;'>The book is not available!</span>";
    }
  }
} else {
  echo "wala laman";
}
