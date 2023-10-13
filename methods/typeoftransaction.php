<?php
include "../connection/oopconnection.php";

date_default_timezone_set('Asia/Manila');
$currdate = date("Y-m-d H:i:s");

if (isset($_POST['selecteditemstobeprocess']) && isset($_POST['userid']) && isset($_POST['adminid'])) {

  $selecteditems = json_decode($_POST['selecteditemstobeprocess']);
  $id = $_POST['userid'];
  $admid = $_POST['adminid'];

  // process the transaction 
  require_once '../methods2/manageTransaction.php';
  $getAdminFN = "SELECT * FROM users where user_id = $admid";
  $resAFN = $conn->query($getAdminFN);
  $rowAFN = $resAFN->fetch_assoc();
  $AdminFull = $rowAFN['Fname'] . ' ' . $rowAFN['Lname'];
  $transactionClass = new Transaction($conn, $id, $admid, $currdate, $AdminFull);
  $result = 0;

  foreach ($selecteditems as $transaction) {
    $typetrans = $transaction->transType;
    $transno = $transaction->transNo;
    $sql = "SELECT *, r.TransactionNo as rtran FROM returntran r, users , borrowtran , book_collection bc
      where BTransactionNo = $transno AND r.user_id = users.user_id AND bc.ISBN = r.ISBN
      AND borrowtran.TransactionNo = r.BTransactionNo ";
    if ($typetrans == "returnonly") {
      $result += $transactionClass->returnBook($sql, $typetrans, $transno);
    } else if ($typetrans == "payonly") {
      $result += $transactionClass->payFine($sql, $typetrans, $transno);
    } else {
      $result += $transactionClass->returnPay($sql, $typetrans, $transno);
    }
  }
  if ($result == count($selecteditems)) {
    include "updaterecords.php";

    $timestamp = strtotime($currdate);
    $transdate = date("F j, Y g:i A", $timestamp);

    $adfull = "SELECT *, concat(Fname,' ',Lname) as fullname FROM users where user_id = $admid";
    $res12312 = $conn->query($adfull) or die($conn->error);
    $fetchres = $res12312->fetch_assoc();
    if (count($selecteditems) > 0) {
      // FOR PRINT OUTPUT !

      $getmemname = "SELECT * FROM users where user_id = $id ";
      $resulta1 = $conn->query($getmemname);
      $showrow1 = $resulta1->fetch_assoc();
      echo "
      <center id='top'>
      <div class='logo'></div>
      <h2 class='text-center'>Karlib Library</h2>
  </center><!--End InvoiceTop-->
 
<div id='mid'>
  <div class='text-left d-flex align-items-center flex-column'>
      <p>Address: Street City, State 0000 </p>
      <p>Email: library@karlib.com</p> 
      <p>Phone: 555-555-5555</p>
  </div>
</div>
  <div id='mid'>
      <div class='info'>
          <h2>Reciept: #Rec.1002</h2>
          <p>
              Date: $transdate<br>
              Borrower: $showrow1[Fname] $showrow1[Lname](Student)<br>
              Processed by: $AdminFull(Librarian)<br>
          </p>
      </div>
  </div><!--End Invoice Mid-->

  <div id='bot' class='mt-2'>
      <div id='table'>
          <table>
              <tr class='tabletitle'>
                  <td class='item'colspan='2'><h2>Item</h2></td>
                  <td ><h2>Type</h2></td>
                  <td><h2>Sub Total</h2></td>
              </tr>
            ";

      foreach ($selecteditems as $transaction) {
        $typetrans = $transaction->transType;
        $transno = $transaction->transNo;


        $sql = "SELECT *, r.TransactionNo as rtran FROM returntran r, users , borrowtran , book_collection bc
     where BTransactionNo = $transno AND r.user_id = users.user_id AND bc.ISBN = r.ISBN
     AND borrowtran.TransactionNo = r.BTransactionNo ";

        $res = $conn->query($sql) or die($conn->error);

        $row = $res->num_rows;
        if ($row > 0) {

          $totalpenshow = 0;
          while ($rows = $res->fetch_assoc()) {
            $name = $rows['Fname'];
            $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
            $totalpenalty = $totaloverdue * 20;
            $timestamp = strtotime($rows['DateBorrowed']);
            $dateborr = date("F j, Y g:i A", $timestamp);
            echo "
            <tr class='service'>
            <td class='tableitem' colspan='2'><p class='itemtext'>Book: " . substr($rows['title'], 0, 20) . ".. /  #$rows[ISBN] </p></td>
            <td class='tableitem'><p class='itemtext'>" . generateTransactionTypeReciept($typetrans) . "</p></td>
            <td class='tableitem'><p class='itemtext'>₱ $totalpenalty</p></td>
        </tr>
      ";
            $totalpenshow += $totalpenalty;
          }
        }
      }
      echo "
    <tr class='tabletitle'>
      <td class='tableitem' colspan='2'><h3>Fine Payment</h3></td>
        <td class='Rate'><h3>Total</h3></td>
        <td class='payment'><h3>₱ $totalpenshow</h3></td>
    </tr>
      
    </table>
    </div><!--End Table-->

    <div id='legalcopy'>
        <p class='legal'>
          <strong>Thank you for your payment/returns!</strong> We appreciate your prompt payment for the transactions listed in this receipt. Payment is expected within 31 days; please complete any remaining transactions within that time. Please note that a 5% monthly interest charge will be applied to overdue invoices

        </p>
    </div>
</div>
</div>
   
    ";
    }
  } else {
    echo "Error: ";
  }
}
function generateTransactionTypeReciept($type)
{
  // 1 is unreturn status , 0 is returned status
  if ($type == 'returnonly') return 'R';
  if ($type == 'payonly') return 'P';
  if ($type == 'returnpay') return 'P&R';

  return 'type not match!';
}

// include "../connection/oopconnection.php";
// $paying = "SELECT * FROM returntran;";
// $whopay = $conn->query($paying);
// while ($road = $whopay->fetch_assoc()) {
//   if ($road['Status'] == 'OK') {
//     insert to transaction history all oks
//     $sqlsavetohistory = "INSERT INTO settledtrans SELECT * FROM returntran WHERE BTransactionNo = " . $road['BTransactionNo'] . "";
//     $conn->query($sqlsavetohistory);

//     $del = "DELETE FROM borrowtran WHERE TransactionNo = " . $road['BTransactionNo'] . "";
//     $conn->query($del);
//     $upstatus = "DELETE FROM returntran WHERE BTransactionNo = " . $road['BTransactionNo'] . "";
//     $conn->query($upstatus);
//   }
// }
