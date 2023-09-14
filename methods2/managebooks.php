<?php 
include "../connection/oopconnection.php";
echo "
<h1 style='color:#222;'></h1>
<button id='addnewbook' onclick='addnewbookshowmodal()'>ADD NEW BOOK +</button>
   <table id='tblofmanageb'>
   <thead>
<tr>
   <th>Book IMAHE</th>
   <th>ISBN</th>
   <th>Title</th>
   <th>Author</th>
 
   
   <th>Action</th>
</tr>
</thead>";

$table = $conn->query("SELECT * FROM stocks st, book_collection bc where st.ISBN = bc.ISBN ORDER BY Title desc") or die($conn->error);
while ($row= $table->fetch_assoc()) {
   $isbnn= $row['ISBN'];
      $sqlImg = "SELECT * FROM book_image where ISBN = '$isbnn'";
      $resultImg = mysqli_query($conn, $sqlImg);
      $rowImg = mysqli_fetch_assoc($resultImg);
         echo"    
         <tr class='managebookrows'>";
            if ($rowImg['status'] == 0) {
                $filename = "../booksimg/book".$row['ISBN']."*";
               $fileInfo = glob($filename);
               $fileext = explode(".", $fileInfo[0]);
              
               $fileActualExt1 = strtolower(end($fileext));

               echo "<td><img data-imgsrc='booksimg/book".$row['ISBN'].".$fileActualExt1' src='booksimg/book".$row['ISBN'].".$fileActualExt1?".mt_rand()."'></td>";
            }
            else {
               echo "<td><img data-imgsrc='booksimg/bookdefault.png' src='booksimg/bookdefault.png'></td>";
           
            }
         echo"
           <td>".$row['ISBN']."</td>
           <td>".$row['title']."</td>
           <td> ".$row['author']."</td>
           <td id='btnaction'>
          <button onclick='managebedit(event)' data-edit='".$row['ISBN']."'>edit</button>
          <button onclick='delfstage(event)'data-del='".$row['ISBN']."'>delete</button>
          </td> 
    
       </tr>";
        
               
}

    echo "</table>";
   
$conn->close();

?>
