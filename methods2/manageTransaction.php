
<?php

class Transaction
{
    private $conn;
    private $userId;
    private $adminId;
    private $currDate;
    private $adminFullName;

    public function __construct($db, $userId, $adminId, $currDate, $fullNameAdmin)
    {
        $this->conn = $db;
        $this->userId = $userId;
        $this->adminId = $adminId;
        $this->currDate = $currDate;
        $this->adminFullName = $fullNameAdmin;
    }

    public function borrowBook($userId, $isbn, $dueDate)
    {
        // Logic to create a new borrowing transaction
    }

    public function returnBook($getTransactionQuery, $TransactionType, $transno)
    {
        // Logic to mark a borrowing transaction as returned
        $this->recordTransaction($getTransactionQuery, $TransactionType);

        //returnonly sets the isbookreturn to 0
        $updateBTBLQuery = "UPDATE borrowtran SET IsBookReturned = 0 where TransactionNo = ?";
        $stmtUpdateBorrow = $this->conn->prepare($updateBTBLQuery);
        $stmtUpdateBorrow->bind_param('s', $transno);
        $stmtUpdateBorrow->execute();
        $updateRTBLQuery = "UPDATE returntran SET DateReturned = ? where BTransactionNo = ?";
        $stmtUpdateReturnDate = $this->conn->prepare($updateRTBLQuery);
        $currDate1 = $this->currDate;
        $stmtUpdateReturnDate->bind_param('ss', $currDate1, $transno);
        $stmtUpdateReturnDate->execute();

        $getISBNQuery = "SELECT ISBN FROM returntran WHERE BTransactionNo = ?";

        $stmtGetISBN = $this->conn->prepare($getISBNQuery);
        $stmtGetISBN->bind_param("s", $transno);
        $stmtGetISBN->execute();

        $isbnData = $stmtGetISBN->get_result()->fetch_assoc();

        $ISBN = $isbnData['ISBN'];
        $this->updateBookAvailabilityAndCount($ISBN);

        $stmtUpdateBorrow->close();
        $stmtUpdateReturnDate->close();
        $stmtGetISBN->close();

        return 1;
    }
    // Reusable method to update stocks based on returning books
    private function updateBookAvailabilityAndCount($ISBN)
    {
        // Update book availability and borrowed count based on returning logic
        $sqlCheckAvailability = "SELECT * FROM stocks WHERE ISBN = ?";
        $stmtCheckAvailability = $this->conn->prepare($sqlCheckAvailability);
        $stmtCheckAvailability->bind_param("s", $ISBN);
        $stmtCheckAvailability->execute();
        $stockData = $stmtCheckAvailability->get_result()->fetch_assoc();

        $available = $stockData['available'] + 1;
        $borrowed = $stockData['no_borrowed_books'] - 1;
        // Update stocks using prepared statement
        $sqlUpdateStocks = "UPDATE stocks SET available = ?, no_borrowed_books = ? WHERE ISBN = ?";
        $stmtUpdateStocks = $this->conn->prepare($sqlUpdateStocks);
        $stmtUpdateStocks->bind_param("iis", $available, $borrowed, $ISBN);
        $stmtUpdateStocks->execute();
    }
    public function reserveBook($userId, $isbn)
    {
        // Logic to create a new reservation transaction
    }

    public function cancelReservation($transactionId)
    {
        // Logic to cancel a reservation transaction
    }

    public function payFine($getTransactionQuery, $TransactionType, $transno)
    {
        $this->recordTransaction($getTransactionQuery, $TransactionType);
        // Payonly sets the paypenalties to value of overdue
        $getOverdueQuery = "SELECT BTransactionNo, Overdue FROM returntran WHERE BTransactionNo = ?";
        $stmtGetOverdue = $this->conn->prepare($getOverdueQuery);
        $stmtGetOverdue->bind_param("s", $transno);
        $stmtGetOverdue->execute();
        $resultOverdue = $stmtGetOverdue->get_result();

        if ($resultOverdue->num_rows > 0) {
            while ($rowOverdue = $resultOverdue->fetch_assoc()) {
                $transactionNo = $rowOverdue['BTransactionNo'];
                $overdueAmount = $rowOverdue['Overdue'];

                $updatePaidPenaltiesQuery = "UPDATE returntran SET paidpenalties = ? WHERE BTransactionNo = ?";
                $stmtUpdatePaidPenalties = $this->conn->prepare($updatePaidPenaltiesQuery);
                $stmtUpdatePaidPenalties->bind_param("is", $overdueAmount, $transactionNo);
                $stmtUpdatePaidPenalties->execute();
            }
        }

        // Close the prepared statements
        $stmtGetOverdue->close();
        $stmtUpdatePaidPenalties->close();
        return 1;
    }
    private function recordTransaction($queryTransaction, $transactionType)
    {
        $transactionData = $this->conn->query($queryTransaction) or die($this->conn->error);
        $row = $transactionData->fetch_assoc();
        if ($row) {
            $user_id = $this->userId;
            $transactionDate = $this->currDate;
            $admin_id = $this->adminId;
            $admin_fullname = $this->adminFullName;
            if ($transactionType === 'returnonly') {

                $status = $row['paidpenalties'] < $row['Overdue'] ? 'Return(Late)' : 'OK';
                $ISBN = $row['ISBN'];
                $BTransactionNo = $row['BTransactionNo'];
                $TransactionType = 'Return Only';
                $statusValue = $status;

                $stmt = $this->conn->prepare("INSERT INTO transaction_history (user_id, transactionDate, ISBN, BTransactionNo, TransactionType, admin_id, status, admin_fullname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param("issisiss", $user_id, $transactionDate, $ISBN, $BTransactionNo, $TransactionType, $admin_id, $statusValue, $admin_fullname);
            }
            if ($transactionType === 'payonly') {
                $status = $row['IsBookReturned'] == 1 ? 'Unreturned' : 'OK';
                $ISBN = $row['ISBN'];
                $BTransactionNo = $row['BTransactionNo'];
                $TransactionType = 'Pay Only';
                $statusValue =  $status;

                $stmt = $this->conn->prepare("INSERT INTO transaction_history (user_id, transactionDate, ISBN, BTransactionNo, TransactionType, admin_id, status, admin_fullname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param("issisiss", $user_id, $transactionDate, $ISBN, $BTransactionNo, $TransactionType, $admin_id, $statusValue, $admin_fullname);
            }
            if ($transactionType === 'returnpay') {
                $ISBN = $row['ISBN'];
                $BTransactionNo = $row['BTransactionNo'];
                $TransactionType = 'Return & Pay';
                $statusValue =  'OK';
                $stmt = $this->conn->prepare("INSERT INTO transaction_history (user_id, transactionDate, ISBN, BTransactionNo, TransactionType, admin_id, status, admin_fullname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issisiss", $user_id, $transactionDate, $ISBN, $BTransactionNo, $TransactionType, $admin_id, $statusValue, $admin_fullname);
            }

            $stmt->execute();
            $stmt->close();
        }
    }
    public function returnPay($getTransactionQuery, $TransactionType, $transno)
    {
        //adding to history
        $this->recordTransaction($getTransactionQuery, $TransactionType);
        // Set status to OK in returntran table
        $updateStatusQuery = "UPDATE returntran SET Status = 'OK' WHERE BTransactionNo = ?";
        $stmtUpdateStatus = $this->conn->prepare($updateStatusQuery);
        $stmtUpdateStatus->bind_param("i", $transno);
        $stmtUpdateStatus->execute();
        $stmtUpdateStatus->close();

        // Check if the book i s returned or not for tblstock
        $checkBookReturnedQuery = "SELECT IsBookReturned FROM borrowtran WHERE TransactionNo = ?";
        $stmtCheckBookReturned = $this->conn->prepare($checkBookReturnedQuery);
        $stmtCheckBookReturned->bind_param("i", $transno);
        $stmtCheckBookReturned->execute();
        $result = $stmtCheckBookReturned->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['IsBookReturned'] == 1) {
                // Book is returned;; update book availability and count
                $getISBNQuery = "SELECT ISBN FROM returntran WHERE BTransactionNo = ?";
                $stmtGetISBN = $this->conn->prepare($getISBNQuery);
                $stmtGetISBN->bind_param("i", $transno);
                $stmtGetISBN->execute();
                $ISBNResult = $stmtGetISBN->get_result();

                if ($ISBNResult->num_rows > 0) {
                    $ISBNRow = $ISBNResult->fetch_assoc();
                    $this->updateBookAvailabilityAndCount($ISBNRow['ISBN']);
                }
            }
        }

        $stmtCheckBookReturned->close();
        $stmtGetISBN->close();
        return 1;
    }
}


    // public function getTransactionsByUser($userId)
    // {
    //     // Retrieve and return all transactions for a user
    // }

    // public function getTransactionDetails($transactionId)
    // {
    //     // Retrieve and return details of a specific transaction
    // }
