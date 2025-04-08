<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("location: ../login/login_server.php");
    exit();
}

// Include the Connection class
include_once('../basic_info.php');
include_once('../connection.php');
include_once('../header/header.php');
include_once('return_books.html'); // Assuming you have a separate HTML file for returning books

// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Set the return date to the current date
$returnDate = date("Y-m-d");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the input data
    $memberID = sanitizeData($_POST['memberID']);
    $bookID = sanitizeData($_POST['bookID']);

    // Create a new connection instance
    $conn = new Connection();
    $conn->setConnection();
    $connection = $conn->getConnection();

    // Check if the book is already returned
    $checkQuery = "SELECT * FROM transactions WHERE MemberID = '$memberID' AND BookID = '$bookID' AND is_returned = 0";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Update the transaction record to mark it as returned
        $updateQuery = "UPDATE transactions SET ReturnDate = '$returnDate', is_returned = 1 WHERE MemberID = '$memberID' AND BookID = '$bookID'";
        if (mysqli_query($connection, $updateQuery)) {
            echo '<p class="success_msg">Book Returned Successfully!</p>';
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    } else {
        echo '<p class="error_msg">Book not found or already returned!</p>';
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
