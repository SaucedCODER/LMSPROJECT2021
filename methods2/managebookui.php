<?php
include "../connection/oopconnection.php";

if ($_SERVER['REQUEST_METHOD'] === "DELETE" && isset($_GET['isbn'])) {
    $delete = $_GET['isbn'];
    $result = deleteBook($conn, $delete);
    $response = [
        'success' => $result,
        'message' => $result ? "Book with ISBN: '$delete' deleted successfully." : 'Failed to delete the book.'
    ];
    echo json_encode($response);
    exit;
}
//Function for deleting book to the database
function deleteBook($conn, $isbn)
{
    $result = true;

    // Delete the book from the database
    $deleteBookQuery = "DELETE FROM book_collection WHERE ISBN = ?";
    $deleteStockQuery = "DELETE FROM stocks WHERE ISBN = ?";
    $deleteBookImgQuery = "DELETE FROM book_image WHERE ISBN = ?";

    //Reuse the same statement Delete the book data
    $stmt = $conn->prepare($deleteBookQuery);
    $stmt->bind_param("s", $isbn);
    if (!$stmt->execute()) {
        $result = false;
    }
    $stmt->close();

    //Reuse the same statement Delete the book stock
    $stmt = $conn->prepare($deleteStockQuery);
    $stmt->bind_param("s", $isbn);
    if (!$stmt->execute()) {
        $result = false;
    }
    $stmt->close();
    // Reuse the same statement for Book Image data in db deletion
    $stmt = $conn->prepare($deleteBookImgQuery);
    $stmt->bind_param("s", $isbn);
    if (!$stmt->execute()) {
        $result = false;
    }
    // Delete the book image file (multiple extensions)
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    foreach ($allowedExtensions as $extension) {
        $filePath = "../booksimg/book$isbn.$extension";
        if (file_exists($filePath)) {
            if (!unlink($filePath)) {
                $result = false;
            }
        }
    }

    return $result;
}

//Get Data to Update
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['isbn'])) {
    $books = $_GET['isbn'];
    $sqli = "SELECT * FROM book_collection bc,stocks st WHERE st.ISBN = '$books' and bc.ISBN = st.ISBN LIMIT 1";
    $res = $conn->query($sqli);
    $row = $res->fetch_assoc();

    // Check if the book data exists
    if ($row) {
        // Create an associative array to hold the book data
        $bookData = array(
            'isbn' => $row['ISBN'],
            'title' => $row['title'],
            'author' => $row['author'],
            'abstract' => $row['abstract'],
            'category' => $row['category'],
            'bookprice' => $row['book_price'],
            'yearpublished' => $row['year_published'],
            'publisher' => $row['publisher'],
            'quantity' => $row['quantity']

        );

        // Retrieve the book image status
        $isbnn = $row['ISBN'];
        $sqlImg = "SELECT * FROM book_image WHERE ISBN = '$isbnn'";
        $resultImg = mysqli_query($conn, $sqlImg);

        // Check if the query executed successfully
        if ($resultImg) {
            $rowImg = mysqli_fetch_assoc($resultImg);

            // Check if an image is available
            if ($rowImg && $rowImg['status'] == 0) {
                // Get the image file extension
                $filename = "../booksimg/book" . $row['ISBN'] . "*";
                $fileInfo = glob($filename);

                // Check if image file(s) exist
                if ($fileInfo && is_array($fileInfo) && count($fileInfo) > 0) {
                    $fileext = explode(".", $fileInfo[0]);
                    $fileActualExt = strtolower(end($fileext));

                    // Add image URL to the book data
                    $bookData['image'] = 'booksimg/book' . $row['ISBN'] . '.' . $fileActualExt;
                } else {
                    // No image found, use default
                    $bookData['image'] = 'booksimg/bookdefault.png';
                }
            } else {
                // No image found, use default
                $bookData['image'] = 'booksimg/bookdefault.png';
            }
        } else {
            // Error in executing the query
            echo json_encode(array('error' => 'Error fetching book image'));
            exit; // Terminate the script
        }

        // Return the book data in JSON format
        echo json_encode($bookData);
    } else {
        // Return an error message if the book data is not found
        echo json_encode(array('error' => 'Book data not found'));
    }
}
// if (isset($_GET['action'])) {
//     echo json_encode(['haha' => false]);
// }
// refactored
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $response = [];
    if ($action === 'insert') {


        // Handle the insert operation
        $isbn = $conn->real_escape_string($_POST['isbn']);
        $quantity = intval($_POST['quantity']);
        $insertData = [
            'ISBN' => $conn->real_escape_string($_POST['isbn']),
            'title' => $conn->real_escape_string($_POST['title']),
            'author' => $conn->real_escape_string($_POST['author']),
            'abstract' => $conn->real_escape_string($_POST['abstract']),
            'category' => $conn->real_escape_string($_POST['category']),
            'book_price' => floatval($_POST['bookprice']),
            'year_published' => intval($_POST['yearpublished']),
            'publisher' => $conn->real_escape_string($_POST['publisher']),
        ];

        // Check if ISBN already exists (similar to your existing code)
        $duplicateCheck = "SELECT * FROM book_collection WHERE ISBN = ?";
        $stmt = $conn->prepare($duplicateCheck);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $stmt->store_result();
        $numRows = $stmt->num_rows;

        if ($numRows > 0) {
            // ISBN already exists, return an error
            $response['success'] = false;
            $response['message'] = 'ISBN already exists. Please choose a different ISBN.';
        } else {
            //checking if image file  exists
            $imagefile = !isset($_FILES['file']) ? false : $_FILES['file'];
            //handle image file upload
            $imageUploadResponse = handleFileUpload($imagefile, $isbn, $conn);

            $insertStocksResult = insertOrUpdateStockData($conn, $isbn, $quantity, true);

            $insertResult = insertBook($conn, $insertData);

            if ($insertResult && $insertStocksResult && $imageUploadResponse['success']) {
                // Book inserted successfully
                $response['success'] = true;
                $response['message'] = 'New book added successfully.';
            } else {
                // Error occurred during insertion
                $response['success'] = false;
                $response['message'] = "Error adding new book. error_specified: " . !$insertResult ? 'insert Book basic delails' : 'insert stock delails';
            }


            if (!$imageUploadResponse['success']) {
                // If image upload fails, update the main response
                $response['success'] = false;
                $response['message'] = 'Error uploading book image. ' . $imageUploadResponse['message'];
            }
        }

        // Return JSON response
        echo json_encode($response);
        exit;
    } elseif ($action === 'update') {

        // Handle the update operation

        $isbn = $conn->real_escape_string($_POST['isbn']);
        $quantity = intval($_POST['quantity']);
        $updateData = [
            'title' => $conn->real_escape_string($_POST['title']),
            'author' => $conn->real_escape_string($_POST['author']),
            'abstract' => $conn->real_escape_string($_POST['abstract']),
            'category' => $conn->real_escape_string($_POST['category']),
            'book_price' => floatval($_POST['bookprice']),
            'year_published' => intval($_POST['yearpublished']),
            'publisher' => $conn->real_escape_string($_POST['publisher']),

        ];
        //checking if image file  exists
        $imagefile = !isset($_FILES['file']) ? false : $_FILES['file'];
        //handle image file upload
        $fileUploadResult = handleFileUpload($imagefile, $isbn, $conn);
        $insertStocksResult = insertOrUpdateStockData($conn, $isbn, $quantity, false);

        // Call the updateBook function with the ISBN and update data
        $updateResult = updateBook($conn, $isbn, $updateData);

        if ($updateResult && $insertStocksResult && $fileUploadResult['success']) {

            $response['success'] = true;
            $response['message'] = 'Book updated successfully.';
            // Book updated successfully
            if ($updateResult === 3 && $fileUploadResult['success'] === 3 && $insertStocksResult === 3) {
                $response['message'] = array(
                    'title' => 'No Changes Detected',
                    'text' => $message = "Book titled: " . $updateData['title']
                );
            }
        } else {
            // Error occurred during update
            $response['success'] = false;
            $response['message'] = "Failed to update Book. Please try again later or contact support for assistance.";;
        }


        // Return JSON response
        echo json_encode($response);
        exit;
    }
}
// Function to handle image uploads

function handleFileUpload($file, $isbn, $conn)
{
    $response = [];

    if ($file && $file['name']) {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];

        // Define the target directory and file name
        $uploadDirectory = "../booksimg/";
        $fileNameNew = "book" . $isbn . "." . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileDestination = $uploadDirectory . $fileNameNew;

        // Check if the file was successfully moved to the target directory
        if (move_uploaded_file($fileTmpName, $fileDestination)) {

            if (!bookExists($conn, $isbn)) {

                $sql = "INSERT INTO book_image(ISBN, status) VALUES ('$isbn', 0)";
                $result = mysqli_query($conn, $sql);
            } else {
                $sql = "UPDATE book_image SET status = 0 WHERE ISBN = '$isbn'";
                $result = mysqli_query($conn, $sql);
            }
            if ($result) {
                // Image record inserted successfully
                $response['success'] = true;
                $response['message'] = 'Image uploaded and record inserted successfully.,';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error inserting image record into the database.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Error moving the uploaded file to the destination directory.';
        }
    } else {
        //setting book image to default in the database if doesnt have file uploaded

        $sqlImg = "SELECT * FROM book_image WHERE ISBN = '$isbn'";
        // Execute the SQL query
        $resultImg = mysqli_query($conn, $sqlImg);
        // Check if the book is not exist set to default image
        if ($resultImg && mysqli_num_rows($resultImg) <= 0) {
            $sqlInsert = "INSERT INTO book_image (ISBN) VALUES ('$isbn')";
            $result = mysqli_query($conn, $sqlInsert);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'No file was uploaded. successfully set to Default image';
            } else {
                $response['success'] = false;
                $response['message'] = "Error inserting ISBN: " . mysqli_error($conn);
            }
        }
        // 'No file was uploaded. nothing happened'
        $response['success'] = 3;
    }

    return $response;
}
function bookExists($conn, $isbn)
{
    $sqlImg = "SELECT COUNT(*) AS count FROM book_image WHERE ISBN = ?";
    if ($stmt = $conn->prepare($sqlImg)) {
        $stmt->bind_param("s", $isbn);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row['count'] > 0) {
            return true;
        } else {
            return false;
        }
    }
}
// Function to insert book data

function insertBook($conn, $data)
{
    $fields = array_keys($data);

    $placeholders = implode(", ", array_fill(0, count($fields), "?"));

    $sql = "INSERT INTO book_collection (" . implode(", ", $fields) . ") VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);

    $paramTypes = str_repeat("s", count($fields));
    $bindParams = [$paramTypes];

    foreach ($fields as $field) {
        $bindParams[] = $data[$field];
    }

    // Bind parameters dynamically
    $stmt->bind_param(...$bindParams);

    if ($stmt->execute()) {
        $stmt->close();
        return true; // Insert successful
    } else {
        $stmt->close();
        return false; // Insert failed
    }
}

// Function to update book data
function updateBook($conn, $isbn, $updateData)
{
    $updateFields = [];
    $updateParams = [];
    $paramTypes = '';
    // Construct the SET clause for the SQL query dynamically
    foreach ($updateData as $field => $value) {
        $updateFields[] = "`$field` = ?";
        $updateParams[] = $value;
        // Determine the data type and append to $paramTypes
        $paramTypes .=  getTypeChar($$field = $value);
    }
    $setClause = implode(", ", $updateFields);
    array_push($updateParams, $isbn);
    $paramTypes .=  's';
    $stmt = $conn->prepare("UPDATE book_collection SET $setClause WHERE ISBN = ?");
    $stmt->bind_param($paramTypes, ...$updateParams);
    if ($stmt->execute()) {
        $rowsAffected = $stmt->affected_rows;
        $stmt->close();
        if ($rowsAffected > 0) {
            // Changes were made
            return true;
        } else {
            // No changes were made
            return 3;
        }
    } else {
        $stmt->close();
        return false;
    }
}



// Function to insert or update stock data
function insertOrUpdateStockData($conn, $isbn, $quantity, $isInsert)
{
    if ($isInsert) {
        // Insert operation
        $nbb = 0;
        $stmtStocks = $conn->prepare("INSERT INTO stocks (ISBN, quantity, available, no_borrowed_books) VALUES (?, ?, ?, ?)");
        $stmtStocks->bind_param("siii", $isbn, $quantity, $quantity, $nbb);
    } else {
        // Retrieve the current number of borrowed books from the database
        $stmtCheckBorrowed = $conn->prepare("SELECT no_borrowed_books FROM stocks WHERE ISBN = ?");
        $stmtCheckBorrowed->bind_param("s", $isbn);
        $stmtCheckBorrowed->execute();

        // Get the result set
        $result = $stmtCheckBorrowed->get_result();

        // Fetch the row as an associative array
        $row = $result->fetch_assoc();
        $stmtCheckBorrowed->close();
        // Check if the update is allowed based on the number of borrowed books
        if ($row['no_borrowed_books'] > $quantity) {
            // Return a failure response
            return false;
        }
        // Update operation
        $stmtStocks = $conn->prepare("UPDATE stocks SET quantity = ? WHERE ISBN = ?");
        $stmtStocks->bind_param("is", $quantity, $isbn);
    }

    if ($stmtStocks->execute()) {
        $rowsAffected = $stmtStocks->affected_rows;
        $stmtStocks->close();
        if ($rowsAffected > 0) {
            // Changes were made
            return true;
        } else {
            // No changes were made
            return 3;
        }
    } else {
        $stmtStocks->close();
        return $stmtStocks->error;;
    }
}



// Function to get parameter type character based on value type
function getTypeChar($value)
{
    if (is_int($value)) {
        return 'i'; // Integer
    } elseif (is_float($value)) {
        return 'd'; // Double (float)
    } else {
        return 's'; // String (default)
    }
}
$conn->close();
