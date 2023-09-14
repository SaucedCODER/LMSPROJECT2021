<?php 
include "../connection/oopconnection.php";
if(isset($_POST['userid'])){
    $uid = $_POST['userid'];
    $sql = "SELECT * FROM transaction_history where user_id = $uid;";
    $res=$conn->query($sql);
    echo "
    <form id='searchhisform' onsubmit='stranshist(event)'>
    <input type='search' name='search' id='searchfortranshis' placeholder='search history......'autocomplete='off'>
    </form>

    
    <table>
    <tr>
    
        <th>ISBN</th>
        <th>Admin_name</th>
        <th>transactionDate</th>
        <th>TransactionType</th>
        <th>status</th>
    </tr>";
    while($row= $res->fetch_assoc()){
                
                $sql1 = "SELECT * FROM users where user_id = '$row[admin_id]';";
                $ress=$conn->query($sql1);
                $rows= $ress->fetch_assoc();
           
           echo "
            <tr>
                <td>$row[ISBN]</td>
                <td>$rows[Fname] $rows[Lname]</td>
                <td>$row[transactionDate]</td>
                <td>$row[TransactionType]</td>
                <td>$row[status]</td>
            </tr>
        ";


    }
    echo "</table>
    ";
}
if(isset($_POST['find'])){
    $valuefind = $_POST['find'];
    $sql = "SELECT * FROM transaction_history WHERE ISBN LIKE '%$valuefind%' or 
     admin_fullname LIKE '%$valuefind%' or  transactionDate LIKE '%$valuefind%' or TransactionType LIKE '%$valuefind%' or `status` LIKE '%$valuefind%'";
    $res= $conn->query($sql) or die($conn->error);
echo "
    <form id='searchhisform' onsubmit='stranshist(event)'>
    <input type='search' name='search' id='searchfortranshis' placeholder='search something......'autocomplete='off'>
    </form>

    
    <table>
    <tr>
    
        <th>ISBN</th>
        <th>Admin_name</th>
        <th>transactionDate</th>
        <th>TransactionType</th>
        <th>status</th>
    </tr>";
    while($row= $res->fetch_assoc()){
                
                
           echo "
            <tr>
                <td>$row[ISBN]</td>
                <td>$row[admin_fullname] </td>
                <td>$row[transactionDate]</td>
                <td>$row[TransactionType]</td>
                <td>$row[status]</td>
            </tr>
        ";


    }
    echo "</table>
    ";
}
