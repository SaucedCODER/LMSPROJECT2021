<?php
include "../connection/oopconnection.php";
//get overdue
$sql = "SELECT * FROM borrowtran;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $paying = "SELECT * FROM returntran where BtransactionNo = " . $row['TransactionNo'] . ";";
        $whopay = $conn->query($paying);
        while ($road = $whopay->fetch_assoc()) {

            if ($road['Status'] !== 'OK') {


                if ($row['IsBookReturned'] == 1) {
                    //unreturn
                    //unreturn and payingpenalties 
                    //unretun and not paying penalties
                    date_default_timezone_set('Asia/Manila');
                    $currdate = date("Y-m-d H:i");
                    $cTime = new DateTime($currdate);
                    $edittime = new DateTime("" . $row['DateBorrowed'] . "");
                    $overdue = $cTime->diff($edittime);
                    $diffInDays  = $overdue->d;
                    $updateoverdue = "UPDATE returntran set Overdue = $diffInDays where BTransactionNo = " . $row['TransactionNo'] . ";";
                    $conn->query($updateoverdue);
                } else {
                    //return
                    if ($road['paidpenalties'] == $road['Overdue']) {
                        //return without penalties
                        $updatestatus = "UPDATE returntran set Status = 'OK' where BtransactionNo = " . $row['TransactionNo'] . ";";
                        $conn->query($updatestatus);
                    } else {
                        //return with unsettled penalties
                        $updatestatus = "UPDATE returntran set Status = 'Returned(Late)' where BtransactionNo = " . $row['TransactionNo'] . ";";
                        $conn->query($updatestatus);
                    }
                }
            } else {

                // $del = "DELETE FROM borrowtran WHERE TransactionNo = " . $row['TransactionNo'] . "";
                // $conn->query($del);
                // $upstatus = "DELETE FROM returntran WHERE BTransactionNo = " . $row['TransactionNo'] . "";
                // $conn->query($upstatus);
            }
        }
    }
}





// checking if the user returns the book then in return transaction the status be returned only and if not the the status will be unreturned
// checl if the user pay the penalty then in return transaction the overdue penalty is 0 and if not then the penalty will be showed
// cannot be okay if theres a penalty evendo you return the book and if you returned it but not paying the penalty

// check if the the pay and return the and if true then the its ok
