<?php
//get book from cart
include "../connection/oopconnection.php";

if (isset($_POST['userid'])) {

  $mem_id = $_POST['userid'];

  $sql3 = "SELECT * FROM cart WHERE user_id = $mem_id";
  $res1 = $conn->query($sql3);
  $row = $res1->num_rows;


  echo "
    <div class='offcanvas-header' >
    <h5 class='offcanvas-title' id='cartCanvasLabel'>Book Cart</h5>
    <button type='button' class='btn btn-outline-danger' data-bs-dismiss='offcanvas' aria-label='Close'><i class='bi bi-x-lg'></i></button>
    </div>
    <div class='offcanvas-body'>
    <ul id='cartItems' class='list-group'>
  ";
  if ($row > 0) {

    while ($rows = $res1->fetch_assoc()) {
      $isbnn = $rows['ISBN'];
      $sqlImg = "SELECT *
      FROM book_collection bc
      JOIN stocks st ON bc.ISBN = st.ISBN
      JOIN book_image bi ON bc.ISBN = bi.ISBN
      WHERE bc.ISBN = '$isbnn'";
      $resultImg = mysqli_query($conn, $sqlImg);
      $rowImg = mysqli_fetch_assoc($resultImg);




      echo " 
      <li class='list-group-item'  onclick=\"toggleCheckboxCart('reserveid{$rows['cart_id']}')\">
     
      <div class='row'>
          <div class='col-1'>
          <input type='checkbox'style='border-radius:50%; cursor:pointer;outline:1px solid blue;' class='form-check-input selectcheck' id='reserveid" . $rows['cart_id'] . "' value='" . $rows['cart_id'] . "' style='cursor:pointer;'>
          </div>
          <div class='col-2'>
          ";

      if ($rowImg['status'] == 0) {
        $filename = "../booksimg/book" . $rows['ISBN'] . "*";
        $fileInfo = glob($filename);
        $fileext = explode(".", $fileInfo[0]);
        $fileActualExt1 = strtolower(end($fileext));

        echo "
           <img class='img-fluid' data-imgsrc='booksimg/book" . $rows['ISBN'] . ".$fileActualExt1' src='booksimg/book" . $rows['ISBN'] . ".$fileActualExt1?" . mt_rand() . "'>";
      } else {
        echo "<img class='img-fluid' data-imgsrc='booksimg/bookdefault.png' src='booksimg/bookdefault.png'>";
      }

      echo "
              </div>
              <div class='col-9'>
                  <h6><b>ISBN:</b> " . $rows['ISBN'] . "</h6>
                  <p><b>Title:</b> " . $rows['book_title'] . "<br>
                  <b>Author:</b> " . $rowImg['author'] . "</p>
              </div>
          </div>
      </li>
            ";
    }

    echo " 
     </ul>
     ";
  } else {
    //before
    // if (isset($reservemess)) {
    //   echo "You Reserve < " . $reservemess . " > books in your account!!";
    // } else {
    //   echo "<p style='font-size:15px;'>No data's found<p>";
    // }
    echo " <div id='emptyCartMessage' class='text-center text-secondary fst-italic fs-6 mt-3'>
    No items in cart.
</div>";
  }
  echo "
    </div>
    <div class='offcanvas-footer p-3 d-flex justify-content-end gap-3'>";
  $checktypesql = "SElECT * FROM accounts where user_id = $mem_id";
  $res = $conn->query($checktypesql);
  $roow = $res->fetch_assoc();
  if ($roow['type'] == "ADMIN") {
    $textbtn = "<button type='button' class='btn btn-primary' onclick='lendshowmodal()'>Lend listed items</button>
    ";
  } else {
    $textbtn = "<button type='button' class='btn btn-primary' oonclick='reserveitems()'>Reserve listed items</button>
      ";
  }
  echo "
    <button onclick='getallchecks()' type='button' class='btn btn-danger' onclick='removeSelectedItems()'>Remove Selected</button>
    " . $textbtn . "
</div>
    ";

  $conn->close();
}
