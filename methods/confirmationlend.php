<?php
include "../connection/oopconnection.php";
session_start();

$response = array();

if (!empty($_POST['lendtouserid']) || !empty($_POST['userid'])) {
  $userid = $_POST['lendtouserid'];
  $adminid = $_POST['userid'];
  $cont = 0;
  $result = $conn->query("SELECT * FROM users where user_id = $userid");

  if ($result) {
    if ($result->num_rows) {
      // Your lending logic here
      $sql2 = "SELECT sum(IsBookReturned) as unreturnedbook FROM borrowtran  where user_id = $userid";
      $res2 = $conn->query($sql2);
      $row2 = $res2->fetch_assoc();
      $canbeborrowed = 3 - $row2['unreturnedbook'];

      if ($canbeborrowed) {
        // No of books in cart maximum of 3 -
        $sql3 = "SELECT count(user_id) as noofbooksincart FROM cart where user_id = $adminid";
        $res3 = $conn->query($sql3);
        $row3 = $res3->fetch_assoc();

        if ($canbeborrowed >= $row3['noofbooksincart']) {
          while ($rowss = $result->fetch_assoc()) {
            // Get current time and due time
            date_default_timezone_set('Asia/Manila');
            $currdate = date("Y-m-d H:i:s");
            $currdate1 = new DateTime($currdate);
            $Adddays = 1;
            $duedate = $currdate1->modify("+{$Adddays} day");
            $stamp = $duedate->format('Y-m-d H:i:s');

            // Fetch books in cart
            $sql = "SELECT * FROM cart WHERE user_id = $adminid";
            $res = $conn->query($sql);
            $rowed = $res->num_rows;
            while ($row = $res->fetch_assoc()) {
              // Check if the book is available
              $sql11 = "SELECT * FROM stocks WHERE ISBN = '{$row['ISBN']}'";
              $res11 = $conn->query($sql11);
              $row11 = $res11->fetch_assoc();

              if ($row11['available']) {
                // Insert the borrow transaction
                $sqlins = "INSERT INTO borrowtran(user_id, ISBN, DateBorrowed, due_date)
                                 VALUES($userid, '{$row['ISBN']}', '$currdate', '$stamp')";
                if ($conn->query($sqlins)) {
                  // Update stock information
                  $sqlcheckavail = "SELECT * FROM stocks WHERE ISBN = '{$row['ISBN']}'";
                  $resforcheck = $conn->query($sqlcheckavail) or die($conn->error);
                  $checkmate = $resforcheck->fetch_assoc();
                  $avai =  $checkmate['available'] - 1;
                  $lends = $checkmate['no_borrowed_books'] + 1;
                  $sqlupdatestoc = "UPDATE stocks SET available = $avai, no_borrowed_books = $lends WHERE ISBN = '{$row['ISBN']}';";
                  if ($conn->query($sqlupdatestoc)) {
                    $cont++;
                  } else {
                    // Handle stock update error
                    $response['error'] = "Failed to update stock for ISBN: {$row['ISBN']}";
                  }
                } else {
                  // Handle borrow transaction insertion error
                  $response['error'] = "Failed to insert borrow transaction for ISBN: {$row['ISBN']}";
                }
              } else {
                // Handle out-of-stock error
                $response['error'] = "OUT OF STOCK! Book title: {$row['book_title']} ISBN: {$row['ISBN']}";
              }
            }

            if ($cont) {
              $response['error'] = null;
              $response['message'] = "You successfully lent $rowed book(s) to {$rowss['Fname']} {$rowss['Lname']}.";
            } else {
              $response['error'] = "No books were lent.";
            }

            // Insert the borrow transactions in return transaction
            $sqlr = "SELECT * FROM borrowtran WHERE DateBorrowed = '$currdate' AND user_id = $userid;";
            $resu = $conn->query($sqlr);
            if ($resu->num_rows > 0) {
              while ($rowed = $resu->fetch_assoc()) {
                // Calculate overdue days
                $cTime = new DateTime($currdate);
                $edittime = new DateTime("{$rowed['DateBorrowed']}");
                $overdue = $cTime->diff($edittime);
                $diffInDays = $overdue->d;
                // Insert data into return transaction
                $sqlinss = "INSERT INTO returntran(user_id, ISBN, BTransactionNo, Overdue, Status)
                                  VALUE({$rowed['user_id']}, '{$rowed['ISBN']}', {$rowed['TransactionNo']}, '$diffInDays', 'UNRETURNED')";
                $conn->query($sqlinss) or die($conn->error);
              }
            }

            // Clear the cart for the current admin user
            $conn->query("DELETE FROM cart WHERE user_id = $adminid");
          }
        } else {
          $response['error'] = "The user can only borrow up to $canbeborrowed book(s) at this time.";
        }
      } else {
        $response['error'] = "The user has already borrowed the maximum allowed of 3 book(s).`";
      }
    } else {
      $response['error'] = "Invalid System id";
    }
  } else {
    if (strlen($userid) == 0) {
      $response['error'] = "No user specified";
    } else {
      $response['error'] = "Invalid id";
    }
  }
}

// Return the JSON response
echo json_encode($response);
