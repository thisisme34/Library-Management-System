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
include_once('add_books.html');
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
    $bookID = sanitizeData($_POST['bookID']);
    $bookTitle = sanitizeData($_POST['book_title']);
    $author = sanitizeData($_POST['author']);
    $price = sanitizeData($_POST['price']);
    $publisherName = sanitizeData($_POST['publisher_name']);
    if (!is_numeric($price) || !is_numeric($bookID)) {
        echo '<p class="error_msg">Invalid input for Price or Book ID. Please enter valid numbers.</p>';
        exit;
    }

    // Create a new connection instance
    $conn = new Connection();
    $conn->setConnection();
    $connection = $conn->getConnection();

    // Insert data into the 'books' table
    $query = "INSERT INTO books (bookID, title, author, price, publisher_name)
              VALUES ('$bookID', '$bookTitle', '$author', '$price', '$publisherName')";

    if (mysqli_query($connection, $query)) {
        echo '<p class="success_msg">Book Added Successfully !</p>';
    } else {
        if (mysqli_errno($connection) == 1062) { // 1062 is the MySQL error code for duplicate entry
            echo '<p class="error_msg">Duplicate Book ID! Please choose a different Book ID.</p>';
        }
        elseif (mysqli_errno($connection) == 1264) {
            // Datatype mismatch error (adjust the error code as per MySQL documentation)
            echo '<p class="error_msg">Datatype mismatch! Please check your input.</p>';} 
        else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
