<?php


function fetch_data()
{
  include "../connection/oopconnection.php";

  $query = "SELECT * from book_collection JOIN stocks ON book_collection.ISBN = stocks.ISBN;";

  $stmt = $conn->prepare($query);
  $stmt->execute();
  $rows = $stmt->get_result();
  if ($rows->num_rows) {
    while ($data = $rows->fetch_assoc()) {
      $arraydata[] = $data;
    }
    return $arraydata;
  } else {
    return 0;
  }


  $stmt->close();
  $conn->close();
}

$fetchData = fetch_data();
if ($fetchData) {
  echo show_data($fetchData);
} else {
  echo "no books found!";
}

function show_data($fetchData)
{

  include "../connection/oopconnection.php";

  echo '<div class="row row-cols-1 row-cols-md-2 g-4">';
  if (count($fetchData) > 0) {


    foreach ($fetchData as $data) {

      if ($data['available'] > 0) {
        $avail = "In Stock: [ " . $data['available'] . " out of " . $data['quantity'] . " ]";
      } else {
        $avail = "Not Availble";
      }
      $isbnn = $data['ISBN'];
      $sqlImg = "SELECT * FROM book_image where ISBN = '$isbnn'";
      $resultImg = $conn->query($sqlImg);
      $rowImg = $resultImg->fetch_assoc();
      echo "<div class='col mh-{250px}' > ";
      echo "
      <div class='card mb-3 h-100' style='max-width: 540px;'>
        <div class='row g-0 h-100'>
          <div class='col-md-4 h-100'data-bookuniq='" . $data['ISBN'] . "'>
        
          ";
      if ($rowImg['status'] == 0) {
        $filename = "../booksimg/book" . $data['ISBN'] . "*";
        $fileInfo = glob($filename);
        $fileext = explode(".", $fileInfo[0]);

        $fileActualExt1 = strtolower(end($fileext));
        echo "<img class='img-fluid h-100 rounded-start' src='booksimg/book" . $data['ISBN'] . ".$fileActualExt1?" . mt_rand() . "'" . $data['ISBN'] . "'>
               ";
      } else {
        echo "<img src='booksimg/bookdefault.png' class='img-fluid h-100 rounded-start'data-bookinfo = '" . $data['ISBN'] . "'>
               ";
      }
      echo "
      </div>
    <div class='col-md-8'>
      <div class='card-body'>
        <h5 class='card-title position-relative'> " . $data['title'] . "</h5>
        <p class='card-text'><span class='badge text-bg-secondary'>ISBN</span> " . $data['ISBN'] . "</p>
        <p class='card-text'><span class='badge text-bg-secondary'>Author</span> " . $data['author'] . "</p>
        <p class='card-text'><span class='badge text-bg-secondary'>Description</span> " . $data['abstract'] . "</p>
        <p class='card-text'><small class='text-body-secondary'>" . $avail . "</small></p>
      
        <button id='addcartbtn' data-isbn='" . $data['ISBN'] . "' type='button' class='btn btn-outline-primary position-absolute bottom-0 end-0'><i class='bi bi-cart-plus fs-5'></i></button>
      </div>

    </div>
  </div>
</div>
</div>";
    }
    $conn->close();
  } else {

    echo "

     ";
  }

  echo "</div>";
}
