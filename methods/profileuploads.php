<?php
include "../connection/procconnection.php";
if(isset($_FILES['file']['name'])){
         
            $id = $_POST['userid'];
            $file = $_FILES['file'];
           $fileName = $file['name'];
           $fileTmpName = $file['tmp_name'];
           $fileSize = $file['size'];
           $fileError = $file['error'];
           $fileType = $file['type'];
       
           $fileExt = explode('.', $fileName); //returns an array of data
           $fileActualExt = strtolower(end($fileExt)); //returns the last item in the array then lowercases it
           $allowed = array('jpg','png','jpeg','gif');
         
           if (in_array($fileActualExt, $allowed)) {
               if ($fileError == 0) {
                   if ($fileSize < 2000000) {
                    $sqlImg = "SELECT * FROM profile_images where user_id = $id";
                    $resultImg = mysqli_query($conn, $sqlImg);
                    $rowImg = mysqli_fetch_assoc($resultImg);
                       
            
                          if ($rowImg['status'] == 0) {
                              $filename = "../usersprofileimg/profile".$id."*";
                             $fileInfo = glob($filename);
                             $fileext = explode(".", $fileInfo[0]);
                             
                             $fileActualExt1 = strtolower(end($fileext));
                             $filePath = "../usersprofileimg/profile$id.".$fileActualExt1;
                                    if (file_exists($filePath)) 
                                    {
                                    unlink($filePath);
                                       
                                    }
                                  
                          }else{
    
                          }



                       $fileNameNew = "profile".$id.".".$fileActualExt;
                     $fileDestination = "../usersprofileimg/".$fileNameNew;
                       move_uploaded_file($fileTmpName, $fileDestination);
                       $sql = "UPDATE profile_images SET status= 0 WHERE user_id='$id';";
                       $result = mysqli_query($conn, $sql);
                      
                       echo "nag upload sya";
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
		mysqli_close($conn);

	?>
    
   