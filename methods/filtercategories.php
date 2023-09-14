<?php
include "../connection/oopconnection.php";

if (isset($_POST['category'])) {

    $link = $_POST['category'];

    $array = array();

    $query = "SELECT * FROM book_collection join stocks on category = '$link' and book_collection.ISBN = stocks.ISBN";

    $res = $conn->query($query);
    while ($row = $res->fetch_assoc()) {
        $array[] = $row;
    }
    function show_data($array)
    {
        include "../connection/oopconnection.php";

        echo '<div class="row row-cols-1 row-cols-md-2 g-4">';
        if (count($array) > 0) {


            foreach ($array as $data) {

                if ($data['available'] > 0) {
                    $avail = "In Stock: [ " . $data['available'] . " out of " . $data['quantity'] . " ]";
                } else {
                    $avail = "Not Availble";
                }
                $isbnn = $data['ISBN'];
                $sqlImg = "SELECT * FROM book_image where ISBN = '$isbnn'";
                $resultImg = $conn->query($sqlImg);
                $rowImg = $resultImg->fetch_assoc();
                echo "<div onclick='viewbookev(event)' class='col' data-bookuniq='" . $data['ISBN'] . "'> ";
                echo "
      <div class='card mb-3' style='max-width: 540px;'>
        <div class='row g-0'>
          <div class='col-md-4'>
        
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
        <h5 class='card-title'> " . $data['title'] . "</h5>
        <p class='card-text'><span class='badge text-bg-secondary'>ISBN</span> " . $data['ISBN'] . "</p>
        <p class='card-text'><span class='badge text-bg-secondary'>Author</span> " . $data['author'] . "</p>
        <p class='card-text'><span class='badge text-bg-secondary'>Description</span> " . $data['abstract'] . "</p>
        <p class='card-text'><small class='text-body-secondary'>" . $avail . "</small></p>
      </div>
    </div>
  </div>
</div>
</div>";
            }
        } else {

            echo "
     ";
        }
        echo "</div>";
    }
    show_data($array);
    $conn->close();
}
