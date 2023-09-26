<?php
function show_data($fetchData)
{

  // Get the current URL
  $currentUrl = "http" . (($_SERVER['HTTPS'] ?? 'off') === 'on' ? 's' : '') . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

  // Parse the URL to extract the project folder name
  $urlParts = parse_url($currentUrl);
  $pathParts = explode('/', trim($urlParts['path'], '/'));
  $projectFolderName = isset($pathParts[0]) ? $pathParts[0] : 'default_project_folder_name';

  include($_SERVER['DOCUMENT_ROOT'] . "/$projectFolderName/connection/oopconnection.php");


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
      echo "<div class=' col'> ";
      echo "
        <div class='book-item card mb-3 h-100 w-100' onclick='viewbookev(event)' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bookuniq='" . $isbnn . "'>
      <div class='row g-0 h-100 w-100'>
        <div class='col-md-4'  >
        ";
      if ($rowImg['status'] == 0) {
        $filename = "../booksimg/book" . $data['ISBN'] . "*";
        $fileInfo = glob($filename);
        $fileext = explode(".", $fileInfo[0]);
        $fileActualExt1 = strtolower(end($fileext));
        echo "<img class='img-fluid h-100 w-100 rounded-start' src='booksimg/book" . $data['ISBN'] . ".$fileActualExt1?" . mt_rand() . "'" . $data['ISBN'] . "'>
              ";
      } else {
        echo "<img src='booksimg/bookdefault.png' class='img-fluid h-100 w-100 rounded-start'data-bookinfo = '" . $data['ISBN'] . "'>
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
