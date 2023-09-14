<?php
include "../connection/oopconnection.php";

if (isset($_POST['isbn'])) {

  $isbn = $_POST['isbn'];

  $sql = "SELECT * FROM book_collection,stocks 
    where book_collection.ISBN = '$isbn' 
    and book_collection.ISBN = stocks.ISBN
     LIMIT 1;";

  $res = $conn->query($sql);
  $row = $res->fetch_assoc();

  echo " <div class='bookdata'>   
     <div class='d-flex flex-wrap gap-3'>";

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
    echo "<img src='booksimg/book" . $row['ISBN'] . ".$fileActualExt1?" . mt_rand() . "'" . $row['ISBN'] . "'>
               ";
  } else {
    echo "<img src='booksimg/bookdefault.png'>
               ";
  }
  echo "<div>
  <h5>ISBN:</h5><span> $row[ISBN]</span>  <br><br>
  <h5>Title:</h5> <span> $row[title]</span> <br><br>
  <h5>Author:</h5> <span> $row[author]</span> <br><br>
  <h5>Year Published:</h5><span>  $row[year_published]</span> <br><br>
  <h5>Publisher:</h5> <span> $row[publisher]</span> 
           

        </div>
    </div>
    <hr>
    
    <p><b>Abstract:</b>$row[abstract] Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste autem natus amet cumque dolorem, earum labore numquam molestias itaque non!</p>
    <br>
    <br>
    <h5>Book price:  ₱$row[book_price]</h5> </>
    <br>
    <h5>$avail</h5> <br><br>
    <button type='button' onclick='closebookmodal(event)' class='btn btn-danger'>Close</button>
    </div>";
}
