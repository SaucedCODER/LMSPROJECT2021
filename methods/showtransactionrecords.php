<?php
include "../connection/oopconnection.php";
if (isset($_POST['userid'])) {
  // $paying = "SELECT * FROM returntran;";
  // $whopay = $conn->query($paying);
  // while ($road = $whopay->fetch_assoc()) {
  //   if ($road['Status'] == 'OK') {

  //     $del = "DELETE FROM borrowtran WHERE TransactionNo = " . $road['BTransactionNo'] . "";
  //     $conn->query($del);
  //     $upstatus = "DELETE FROM returntran WHERE BTransactionNo = " . $road['BTransactionNo'] . "";
  //     $conn->query($upstatus);
  //   }
  // }

  $id = $_POST['userid'];


  $sql = "SELECT * FROM borrowtran, users , returntran 
where borrowtran.user_id = '$id' AND users.user_id = '$id' AND returntran.BTransactionNo = borrowtran.TransactionNo 
AND returntran.Status != 'OK' ORDER BY DateBorrowed DESC;";

  $res = $conn->query($sql) or die("failed");
  $row = $res->num_rows;
  if (!$row) {
    echo " <div class='fs-6 m-2 text-center text-muted'>No Unsettle Transaction Found!</div><div class='datasr'style='visibility:hidden;' data-statusr='off'>value</div>";
  } else {
    echo " 
";
    echo "<div class='table-responsive'>
    <table class='table table-responsive table-bordered table-hover'>
    <thead class='bg-black'>
        <tr>
            <th scope='col' width='5%'>
                <input class='form-check-input' onChange='selectAllUnsettled(event)' type='checkbox' />
            </th>
            <th scope='col' width='25%'>ISBN</th>
            <th scope='col' width='20%'>Due Date</th>
            <th scope='col' width='13%'>Status</th>
            <th scope='col' width='12%'>Fine</th>
            <th scope='col' width='25%'>Action</th>
        </tr>
    </thead>
    <tbody>
    ";
    $overallFines = 0;
    while ($rows = $res->fetch_assoc()) {
      $name = $rows['Fname'];
      $totaloverdue = $rows['Overdue'] - $rows['paidpenalties'];
      $totalpenalty = $totaloverdue * 20;
      $overallFines += $totalpenalty;
      $timestamp = strtotime($rows['due_date']);

      $due_date = date("F j, Y g:i A", $timestamp);
      echo "
    <tr>
    <th scope='row'>
        <input class='form-check-input selectitemtransno' id='transno$rows[BTransactionNo]'value='$rows[BTransactionNo]' type='checkbox' />
    </th>
        <td> #$rows[ISBN] </td>
    <td>$due_date</td>
    <td>
     $rows[Status]
    </td>
    <td>
    <span class='fine-amount fw-bolder'>₱ $totalpenalty</span>
    </td>
    
    <td>
    <button class='btn btn-primary' " . generateTransactionOptions($rows['IsBookReturned'], $totalpenalty) . " value='payonly'>Pay</button>
    ";

      echo "
    
    </td>
    </tr>
    
    ";
    }

    echo "
    </tbody>
    <tfoot >
    <tr >
        <td colspan='4' class='text-end'><strong>Total Penalty:</strong></td>
        <td><strong>₱ $overallFines</strong></td>
        <td colspan='1' class='text-end'></td>
    </tr>
</tfoot>
    </table>
  </div>
  ";
  }
}
function generateTransactionOptions($status, $penalties)
{
  $options = '';
  // 1 is unreturn status , 0 is returned status
  if ($status === '1') {
    $options = 'disabled';
  }
  return $options;
}

$conn->close();
