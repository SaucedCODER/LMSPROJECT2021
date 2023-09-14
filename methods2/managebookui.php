<?php 
include "../connection/oopconnection.php";
if(isset($_POST['mbkdel'])){
    $delete = $_POST['mbkdel'];
    $conn->query("DELETE FROM book_collection WHERE ISBN = '$delete'")or die($conn->error);
    $conn->query("DELETE FROM stocks WHERE ISBN = '$delete'")or die($conn->error);
    $conn->query("DELETE FROM book_image WHERE ISBN = '$delete'")or die($conn->error);
    $filePath = "../booksimg/book$delete.jpg";
    if (file_exists($filePath)) 
    {
      unlink($filePath);
       echo "File Successfully Delete."; 
   }
   else
   {
    echo "File does not exists"; 
   }
    echo "1 book is deleted";
}else if(isset($_POST['mbkedit'])){
    $books =  $_POST['mbkedit'];
    $sqli= "SELECT * FROM book_collection where ISBN = '$books' Limit 1";		
     $res =  $conn->query($sqli);
   $row= $res->fetch_assoc();
     echo"
   
 <form onsubmit='updatebook(event)' method='POST' id='bookdataupdate'>
        <h1>EDIT BOOK INFOS</h1>
      <input type ='text'  name = 'isbn' value='".$row['ISBN']."' >   
      <input type ='text'  name = 'title' value='".$row['title']."'> 
      <input type ='text' name = 'author' value='".$row['author']."'>
      <input type ='text'  name = 'abstract' value='".$row['abstract']."'>
      <input type ='text' name = 'category' value='".$row['category']."'>  
      <input type ='text'  name = 'bookprice' value='".$row['book_price']."'> 
      <input type ='text'  name = 'yearpublish' value='".$row['year_published']."'> 
      <input type ='text'  name = 'publisher' value='".$row['publisher']."'> 
      <input type ='hidden'  name = 'bookupdate' value='".$row['ISBN']."' > 
      <button type='submit'name='gg' >UPDATE</button>
      <button onclick='closeeditmodalbk(event)'>CLOSE</button>
 </form>";
 $isbnn = $row['ISBN'];
 $sqlImg = "SELECT * FROM book_image where ISBN = '$isbnn'";
 $resultImg = mysqli_query($conn, $sqlImg);
 $rowImg = mysqli_fetch_assoc($resultImg);
    echo"  
    <form class='imgbbookcontainer'>  
    ";
       if ($rowImg['status'] == 0) {
           $filename = "../booksimg/book".$row['ISBN']."*";
          $fileInfo = glob($filename);
          $fileext = explode(".", $fileInfo[0]);
          $fileActualExt = strtolower(end($fileext));

          echo "<img id='chimg' style='height:18em;width:100%;' data-imgsrc='booksimg/book".$row['ISBN'].".$fileActualExt' src='booksimg/book".$row['ISBN'].".$fileActualExt?" . mt_rand() . "' >";
         
       }
       else {
          echo "<img id='chimg' style='height:18em;' data-imgsrc='booksimg/bookdefault.png' src='booksimg/bookdefault.png'>";
      
       }

 echo"
    <input id='filebdataubook' type='file'onchange='readURL(this)' name='file'>
</form>
 ";
 

        
 
         

}else if(isset($_POST['bookupdate'])){
    $isbn =  $conn->real_escape_string($_POST['isbn']);
    $title = $conn->real_escape_string($_POST['title']);
    $author =  $conn->real_escape_string($_POST['author']);
    $abstract = $conn->real_escape_string($_POST['abstract']);
    $category = $conn->real_escape_string($_POST['category']);
    $bookprice =  $conn->real_escape_string($_POST['bookprice']);
    $yearpub = $conn->real_escape_string($_POST['yearpublish']);
    $publisher = $conn->real_escape_string($_POST['publisher']);

    $updatingbooks = "UPDATE book_collection SET ISBN = '$isbn',title = '$title',author = '$author',abstract = '$abstract',
    category = '$category',book_price = '$bookprice',year_published = '$yearpub',publisher = '$publisher' where ISBN = '$isbn'";
    $result = $conn->query($updatingbooks);
   $gg = 0;

    //book update picture
    if(isset($_FILES['file']['name'])){
         
      
        $file = $_FILES['file'];
       $fileName = $file['name'];
       $fileTmpName = $file['tmp_name'];
       $fileSize = $file['size'];
       $fileError = $file['error'];
       $fileType = $file['type'];
        
       $fileExt = explode('.', $fileName); //returns an array of data
       $fileActualExt = strtolower(end($fileExt)); //returns the last item in the array then lowercases it
       $allowed = array('jpg','png','jpeg');
     
       if (in_array($fileActualExt, $allowed)) {

           if ($fileError == 0) {
            if ($fileSize < 2000000) {
                
                $sqlImg = "SELECT * FROM book_image where ISBN = '$isbn'";
                $resultImg = mysqli_query($conn, $sqlImg);
                $rowImg = mysqli_fetch_assoc($resultImg);
                   
        
                      if ($rowImg['status'] == 0) {
                          $filename = "../booksimg/book".$isbn."*";
                         $fileInfo = glob($filename);
                         $fileext = explode(".", $fileInfo[0]);
                         
                         $fileActualExt1 = strtolower(end($fileext));
                         $filePath = "../booksimg/book$isbn.".$fileActualExt1;

                                if (file_exists($filePath)) 
                                {
                                unlink($filePath);
                                   
                                }
                            
                      }else{

                      }
                
              
                   $fileNameNew = "book".$isbn.".".$fileActualExt;
                 $fileDestination = "../booksimg/".$fileNameNew;
                   move_uploaded_file($fileTmpName, $fileDestination);
                   $sql = "UPDATE book_image SET status= 0 WHERE ISBN='$isbn';";
                   $result = mysqli_query($conn, $sql);
                 
                   $gg += 1;
               } else {
                   echo "Your file is too big!";
               }
           } else {
               echo "There was an error uploading your file!";
           }
       } else {
           echo "You can't upload this type of file!";
       }
 

   }
   $gg += 1;

   if($gg > 0){
       echo "book updated ";
   }

}else if(isset($_POST['bookinsert'])){

    $isbn = $_POST['isbn'];
   $title = $conn->real_escape_string($_POST['title']);
    $author = $_POST['author'];
    $abstract = $_POST['abstract'];
    $category = $_POST['category'];
    $bookprice = $_POST['bookprice'];
    $yearpub = $_POST['yearpublished'];
    $publisher = $_POST['publisher'];
    $quantity = $_POST['quantity'];
    $nbb = 0;
    $cheeckduplicate = "SELECT * FROM book_collection where ISBN = ?";
    $stmtm = $conn->prepare($cheeckduplicate);
    $stmtm -> bind_param("s", $isbn);
    $stmtm->execute();
    $stmtm->store_result();
    $numrows= $stmtm->num_rows;
    if ($numrows) {
        # code...
        echo "ERROR MESSAGE: MAY KAPAREHAS NA ISBN ";
    }else{
        $stmt = $conn->prepare("INSERT INTO book_collection (ISBN, title, author, abstract, category,book_price, year_published, publisher) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssiis",$isbn,$title,$author,$abstract,$category,$bookprice,$yearpub,$publisher);
        $stmt->execute();
    $stmt->close();
        $st = $conn->prepare("INSERT INTO stocks (ISBN,quantity,available,no_borrowed_books) VALUES (?,?,?,?)");
     
         $st->bind_param("siii",$isbn,$quantity,$quantity,$nbb);
         $st->execute();
         $st->close();
        // book image upload
        if(isset($_FILES['file']['name'])){
         
            
            $file = $_FILES['file'];
           $fileName = $file['name'];
           $fileTmpName = $file['tmp_name'];
           $fileSize = $file['size'];
           $fileError = $file['error'];
           $fileType = $file['type'];
       
           $fileExt = explode('.', $fileName); //returns an array of data
           $fileActualExt = strtolower(end($fileExt)); //returns the last item in the array then lowercases it
           $allowed = array('jpg','png','jpeg');

         
           if (in_array($fileActualExt, $allowed)) {
               if ($fileError == 0) {
                   if ($fileSize < 2000000) {
                       $fileNameNew = "book".$isbn.".".$fileActualExt;
                     $fileDestination = "../booksimg/".$fileNameNew;
                       move_uploaded_file($fileTmpName, $fileDestination);
                       $sql = "INSERT INTO book_image(ISBN,status) VALUES('$isbn',0)";
                       $result = mysqli_query($conn, $sql);

                   } else {
                       echo "Your file is too big!";
                   }
               } else {
                   echo "There was an error uploading your file!";
               }
           } else {
               echo "You can't upload this type of file!";
           }
       }else{
        $sqlinsv= "INSERT INTO book_image(ISBN) VALUES('$isbn')";
        $result = mysqli_query($conn, $sqlinsv);
   
       }
       //end  


     echo "System message: New Book successfully added , Book title: $title";


    
    }
     $stmtm->close();
}


$conn->close();

?>