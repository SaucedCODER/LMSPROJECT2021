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
    $stmt = $conn->prepare($deleteBookQuery);
    $stmt->bind_param("s", $isbn);
    if (!$stmt->execute()) {
        $result = false;
    }
    $stmt->close();

    // Delete the book stock
    $deleteStockQuery = "DELETE FROM stocks WHERE ISBN = ?";
    $stmt = $conn->prepare($deleteStockQuery);
    $stmt->bind_param("s", $isbn);
    if (!$stmt->execute()) {
        $result = false;
    }
    $stmt->close();
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
    $sqli = "SELECT * FROM book_collection WHERE ISBN = '$books' LIMIT 1";
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
            'publisher' => $row['publisher']
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

// refactored
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $response = [];
    if ($action === 'insert') {
        // Handle the insert operation
        $isbn = $conn->real_escape_string($_POST['isbn']);
        $insertData = [
            'title' => $conn->real_escape_string($_POST['title']),
            'author' => $conn->real_escape_string($_POST['author']),
            'abstract' => $conn->real_escape_string($_POST['abstract']),
            'category' => $conn->real_escape_string($_POST['category']),
            'book_price' => floatval($_POST['bookprice']),
            'year_published' => intval($_POST['yearpublished']),
            'publisher' => $conn->real_escape_string($_POST['publisher']),
            'quantity' => intval($_POST['quantity']),
        ];

        // Add more fields as needed

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
            // Insert the book into the database using your reusable function
            $insertData = [
                'title' => $title,
                'author' => $author,
                // Add more fields as needed
            ];

            $insertResult = insertBook($conn, $isbn, $insertData);

            if ($insertResult) {
                // Book inserted successfully
                $response['success'] = true;
                $response['message'] = 'New book added successfully.';
            } else {
                // Error occurred during insertion
                $response['success'] = false;
                $response['message'] = 'Error adding new book.';
            }

            // Handle image file upload using the reusable function
            $imageUploadResponse = handleFileUpload($_FILES['file'], $isbn, $conn);

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
        $updateData = [
            'title' => $conn->real_escape_string($_POST['title']),
            'author' => $conn->real_escape_string($_POST['author']),
            'abstract' => $conn->real_escape_string($_POST['abstract']),
            'category' => $conn->real_escape_string($_POST['category']),
            'book_price' => floatval($_POST['bookprice']),
            'year_published' => intval($_POST['yearpublished']),
            'publisher' => $conn->real_escape_string($_POST['publisher']),
            'quantity' => intval($_POST['quantity']),
        ];

        // Call the updateBook function with the ISBN and update data
        $updateResult = updateBook($conn, $isbn, $updateData);

        if ($updateResult) {
            // Book updated successfully
            $response['success'] = true;
            $response['message'] = 'Book updated successfully.';
        } else {
            // Error occurred during update
            $response['success'] = false;
            $response['message'] = 'Error updating book.';
        }
        //handle image file upload
        $response = handleFileUpload($_FILES['file'], $isbn, $conn);

        // Return JSON response
        echo json_encode($response);
        exit;
    }
}
// Function to handle image uploads

function handleFileUpload($file, $isbn, $conn)
{
    $response = [];

    if ($file['name']) {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];

        // Define the target directory and file name
        $uploadDirectory = "../booksimg/";
        $fileNameNew = "book" . $isbn . "." . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileDestination = $uploadDirectory . $fileNameNew;

        // Check if the file was successfully moved to the target directory
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // File uploaded successfully, insert a record in the database
            $sql = "INSERT INTO book_image(ISBN, status) VALUES ('$isbn', 0)";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Image record inserted successfully
                $response['success'] = true;
                $response['message'] = 'Image uploaded and record inserted successfully.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error inserting image record into the database.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Error moving the uploaded file to the destination directory.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'No file was uploaded.';
    }

    return $response;
}
// Function to insert book data

function insertBook($conn, $data)
{
    $fields = array_keys($data);
    array_unshift($fields, 'ISBN');

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
        return true; // Insert successful
    } else {
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
        $updateFields[] = "$field = ?";
        $updateParams[] = $value;

        // Determine the data type and append to $paramTypes
        $paramTypes .=  getTypeChar($value);
    }

    // Add ISBN as the last parameter for the WHERE clause
    $updateParams[] = $isbn;

    $setClause = implode(", ", $updateFields);

    $stmt = $conn->prepare("UPDATE book_collection SET $setClause WHERE ISBN = ?");
    $stmt->bind_param($paramTypes, ...$updateParams);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}



// Function to insert stock data
function insertStockData($conn, $isbn, $quantity)
{
    $nbb = 0;
    $stmtStocks = $conn->prepare("INSERT INTO stocks (ISBN, quantity, available, no_borrowed_books) VALUES (?, ?, ?, ?)");
    $stmtStocks->bind_param("siii", $isbn, $quantity, $quantity, $nbb);

    if ($stmtStocks->execute()) {
        return true;
    } else {
        return false;
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
