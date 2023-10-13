<?php
include "../connection/oopconnection.php";
if (isset($_POST['selecteditemstobeprocess']) and isset($_POST['userid'])) {

  $selecteditems = json_decode($_POST['selecteditemstobeprocess']);

  $id = $_POST['userid'];

  if (count($selecteditems) > 0) {
    echo " <div class='modal-header'>
    <h5 class='modal-title fw-bolder' id='processModalLabel'>Transaction Confirmation</h5>
    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
</div>
<div class='modal-body'>
    <table class='table table-bordered'>
    <thead>
        <tr>
            <th>ISBN</th>
            <th>Due Date</th>
            <th>Fine</th>
            <th>Type of Transaction</th>
        </tr>
    </thead>
    <tbody>
     
";
    foreach ($selecteditems as $transaction) {
      $typetrans = $transaction->transType;
      $transno = $transaction->transNo;

      $sql = "SELECT * FROM returntran r, users , borrowtran
     where BTransactionNo = $transno
     AND  r.user_id = users.user_id AND borrowtran.TransactionNo = r.BTransactionNo ";
      $res = $conn->query($sql) or die($conn->error);

      $row = $res->num_rows;
      if ($row > 0) {
        $res1 = $conn->query($sql) or die($conn->error);
        $rows = $res1->fetch_assoc();
        $name = $rows['Fname'];
        $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
        $totalpenalty = $totaloverdue * 20;

        $timestamp = strtotime($rows['due_date']);

        $due_date = date("F j, Y g:i A", $timestamp);
        echo "
    <tr>
   

        <td data-transNo='$transno' data-transType='$typetrans'> $rows[ISBN]</td>

        <td> $due_date</td>

        <td style='color:blue;'>₱  $totalpenalty</td>
        <td> " . transTypeConvertName($typetrans) . " </td>


    </tr>
  ";
      }
    }
    echo " </tbody>
    </table>
</div>

<div class='modal-footer'>
<div id='confirmBox' class='form-check d-flex me-auto gap-2'>
  <input style='outline:1px solid blue;' type='checkbox'onchange='handleConfirmCheckbox(event)' class='form-check-input' id='confirmCheckbox'>
  <label class='form-check-label' for='confirmCheckbox'>Confirm Transaction</label>
</div>
    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    <button type='button' id='processTransBtn' disabled class='btn btn-primary' data-useridtrans='$id' onclick='selectproccesstransacs(event)' >Process All </button>
    <button type='button' id='printTransacBtn'  class='btn btn-primary d-none' data-useridtrans='$id' onclick='handlePrint(event)' >Print Reciept <i class='bi bi-printer-fill'></i></button>
    <div id='processOverlay' class='processOverlay'></div>

</div>
";
    $conn->close();
  }
}

function transTypeConvertName($type)
{
  if ($type === 'returnonly') return 'Return';
  if ($type === 'payonly') return 'Pay';
  if ($type === 'returnpay') return 'Return & Pay';
}
// <div style='visibility:hidden;' id='triger' data-trigger='$trigger'></div>
// $trigger = 0;
      // while ($check = $res->fetch_assoc()) {

      //   if ($typetrans == "payonly" and $check['Overdue'] === $check['paidpenalties']) {
      //     //check the balance get paidpenalties and overdue
      //     $trigger += 1;
      //     echo "<div style='visibility:hidden;' id='triger' data-trigger='$trigger'>Transaction Type Not Match</div>";
      //     die();
      //   } else if ($typetrans == "returnonly" and $check['IsBookReturned'] == 0) {
      //     //check the status of the book if returned or not
      //     $trigger += 1;
      //     echo "<div style='visibility:hidden;' id='triger' data-trigger='$trigger'>Transaction Type Not Match</div>";
      //     die();
      //   } else if ($typetrans == "returnpay") {

      //     if ($check['IsBookReturned'] == 0 or $check['Overdue'] === $check['paidpenalties']) {
      //       $trigger += 1;
      //       echo "<div style='visibility:hidden;' id='triger' data-trigger='$trigger'>Transaction Type Not Match</div>";
      //       die();
      //     }
      //   }
      // }