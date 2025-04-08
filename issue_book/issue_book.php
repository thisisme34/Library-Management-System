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
include_once('issue_book.html');

// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the input data
    $memberID = sanitizeData($_POST['memberID']);
    $bookID = sanitizeData($_POST['bookID']);
    $issueDate = sanitizeData($_POST['issueDate']);
    $returnDate = sanitizeData($_POST['returnDate']);

    // Create a new connection instance
    $conn = new Connection();
    $conn->setConnection();
    $connection = $conn->getConnection();

    // Check if MemberID exists
    $checkMemberQuery = "SELECT * FROM members WHERE memberID = '$memberID'";
    $resultMember = mysqli_query($connection, $checkMemberQuery);

    // Check if BookID exists
    $checkBookQuery = "SELECT * FROM books WHERE bookID = '$bookID'";
    $resultBook = mysqli_query($connection, $checkBookQuery);

    // Check if BookID has already been issued
    $checkIssuedQuery = "SELECT * FROM transactions WHERE BookID = '$bookID' AND is_returned = 0";
    $resultIssued = mysqli_query($connection, $checkIssuedQuery);

    if (mysqli_num_rows($resultMember) === 0) {
        echo '<p class="error_msg">Member with ID ' . $memberID . ' does not exist!</p>';
    } elseif (mysqli_num_rows($resultBook) === 0) {
        echo '<p class="error_msg">Book with ID ' . $bookID . ' does not exist!</p>';
    } elseif (mysqli_num_rows($resultIssued) > 0) {
        echo '<p class="error_msg">Book with ID ' . $bookID . ' has already been issued and is not returned!</p>';
    } else {
        // Insert data into the 'transactions' table
        $insertQuery = "INSERT INTO transactions (MemberID, BookID,issueDate, DueDate, is_returned)
                        VALUES ('$memberID', '$bookID', '$issueDate', '$returnDate', 0)";

        if (mysqli_query($connection, $insertQuery)) {
            echo '<p class="success_msg">Book Issued Successfully!</p>';
        } else {
            echo '<p class="error_msg">Error: ' . mysqli_error($connection) . '</p>';
        }
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
