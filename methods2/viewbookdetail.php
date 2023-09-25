<?php
session_start();
include "../connection/oopconnection.php";
$currentPage = $_SESSION['userRole'];


$isUser = ($currentPage == 'admins.php' || $currentPage == 'members.php') ? 'true' : 'false';
if (isset($_POST['isbn'])) {

  $isbn = $_POST['isbn'];

  $sql = "SELECT * FROM book_collection,stocks 
    where book_collection.ISBN = '$isbn' 
    and book_collection.ISBN = stocks.ISBN
     LIMIT 1;";

  $res = $conn->query($sql);
  $row = $res->fetch_assoc();

  echo "  
  <div class='modal-header'>
        <h1 class='modal-title fs-5' id='staticBackdropLabel'>View Details</h1>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
     <div class='modal-body text-center gap-1' >   
    ";

  if ($row['available'] > 0) {
    $avail = "In Stock: [ " . $row['available'] . " out of " . $row['quantity'] . " ]";
  } else {
    $avail = "Out of Stock";
  }
  $sqlImg = "SELECT * FROM book_image where ISBN = '$isbn' limit 1";
  $resultImg = $conn->query($sqlImg);
  $rowImg = $resultImg->fetch_assoc();
  if ($rowImg['status'] == 0) {
    $filename = "../booksimg/book" . $row['ISBN'] . "*";
    $fileInfo = glob($filename);
    $fileext = explode(".", $fileInfo[0]);

    $fileActualExt1 = strtolower(end($fileext));
    echo "<img style='width:200px;height:200px;' src='booksimg/book" . $row['ISBN'] . ".$fileActualExt1?" . mt_rand() . "'" . $row['ISBN'] . "'>
               ";
  } else {
    echo "<img style='width:200px;height:200px;' src='booksimg/bookdefault.png'>
               ";
  }
  echo "
  <br>
  <div class='text-start my-2'>
    <b>ISBN:</b><span> $row[ISBN]</span>  <br><br>
    <b>Title:</b> <span> $row[title]</span> <br><br>
    <b>Author:</b> <span> $row[author]</span> <br><br>
    <b>Year Published:</b><span>$row[year_published]</span> <br><br>
    <b>Publisher:</b> <span> $row[publisher]</span> 
    <p><b>Abstract:</b>$row[abstract] </p>
    <span class='badge text-bg-warning'>Book price: ₱$row[book_price]</span>
    <span class='badge text-bg-warning'>$avail</span>
  </div>
  </div>
  <div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    
    <button onclick='addtocart(event)' id='addcartbtn' data-isuser='" . $isUser . "' data-isbn='" . $row['ISBN'] . "' type='button' class='btn btn-primary'><i class='bi bi-cart-plus fs-6'></i> Add to cart</button>
  </div>
   ";
}
