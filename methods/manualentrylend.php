<?php 
  include "../connection/oopconnection.php";
  session_start();


  if((!empty($_POST['lendtouserid']) || !empty($_POST['userid']))){
    //id's
      $userid = $_POST['lendtouserid'];
        $adminid = $_POST['userid'];
        
       $result= $conn->query("SELECT *,concat(Fname,' ',Lname) as fn,concat('Student ID: ',username) as stud FROM users a,accounts b where a.user_id = $userid and b.user_id = a.user_id");
   
        if($result){
            if($rows = $result->num_rows){

                while($rowss= $result->fetch_assoc()){

                    $sqlrows = "SELECT * FROM cart where user_id = $adminid";
                   $res = $conn->query($sqlrows);
                   $rowed=  $res->num_rows;
                    echo "
                  
                <div style='margin:auto;' class='modal-lend-items'>
                    <h3 style='color:#eee;'>Are you sure?<br>Lend ".$rowed." books to ".$rowss['fn']."<br> ".$rowss['stud']."?</h3>
                    <div class='btnlendcontainer' >
                        <a style='width:50%;'' href='#'><button onclick='lendgetidconfirm(event)' style='width:100%'>CONFIRM</button></a>    
                        
                            <button onclick='lendcancelmodal()'>Cancel</button>
                    </div>
    
                </div>
   
                   " ;

                }
             
                $error = "*";
     
          }else{
            $error = "Invalid id";
          }

        }else{
            if (strlen($userid) == 0){
                $error = "please type something!";
                   }else{
                    $error = "Invalid id";
                   }
             
           
        }
        

        echo "<p style='visibility:hidden;' data-lenderr='".$error."' class='lenderror'></p>";
        $conn->close();
        }
     




?>
