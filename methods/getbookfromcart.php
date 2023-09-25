<?php
//get book from cart
include "../connection/oopconnection.php";

if (isset($_POST['userid'])) {

  $mem_id = $_POST['userid'];

  $sql3 = "SELECT * FROM cart WHERE user_id = $mem_id";
  $res1 = $conn->query($sql3);
  $row = $res1->num_rows;
  if ($row > 0) {

    echo "
    <h3 class='cartno' style='padding:.5em;color:teal;background:transparent;'>You have listed " . $row . " book/s</h3>
    <div class='tablecart'>
    <table>
    <tr>
    <th>Select</th>
    <th>Title</th>
    <th>ISBN</th>
    </tr>";
    while ($rows = $res1->fetch_assoc()) {
      echo " 
    <tr>
    <td>

    <input type='checkbox' class='selectcheck' id='reserveid" . $rows['cart_id'] . "' value='" . $rows['cart_id'] . "'>
    
    </td>
      <td >" . $rows['book_title'] . "</td>
      <td>" . $rows['ISBN'] . "</td>
    </tr>
   
    ";
    }


    $checktypesql = "SElECT * FROM accounts where user_id = $mem_id";
    $res = $conn->query($checktypesql);
    $roow = $res->fetch_assoc();
    if ($roow['type'] == "ADMIN") {
      $textbtn = "<button  onclick='lendshowmodal()'>Lend listed items</button>
      </div>";
    } else {
      $textbtn = "<button onclick='reserveitems()'>Reserve listed items</button>
      </div>";
    }
    echo "</table> 
    </div>
    <div class='buttondel'>
    <button onclick='getallchecks()'>Remove Selected Item</button>" . $textbtn . "
    
    ";
  } else {
    if (isset($reservemess)) {
      echo "You Reserve < " . $reservemess . " > books in your account!!";
    } else {
      echo "<p style='font-size:15px;'>No data's found<p>";
    }
  }
  $conn->close();
}
