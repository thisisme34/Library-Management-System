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
include_once('new_user.html');
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
    $memberID = sanitizeData($_POST['MemberID']);
    $firstName = sanitizeData($_POST['FirstName']);
    $lastName = sanitizeData($_POST['LastName']);
    
    $email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p class="error_msg">Invalid email format !</p>';
    }

    $phoneNo = filter_var($_POST['PhoneNo'], FILTER_SANITIZE_NUMBER_INT);
    if (!ctype_digit($phoneNo)) {
       // die("Invalid phone number format ");
       echo '<p class="error_msg">Invalid phone number format !</p>';
        exit;
    }

    $address = sanitizeData($_POST['Address']);

    // Create a new connection instance
    $conn = new Connection();
    $conn->setConnection();
    $connection = $conn->getConnection();

    // Insert data into the 'members' table
    $query = "INSERT INTO members (memberID, FirstName, LastName, Email, Phone_no, Address)
              VALUES ('$memberID', '$firstName', '$lastName', '$email', '$phoneNo', '$address')";

    if (mysqli_query($connection, $query)) {
        //echo '<script>alert("User added successfully.");</script>';
        echo '<p class="success_msg">User Added Successfully !</p>';
    } else {
        if (mysqli_errno($connection) == 1062) { // 1062 is the MySQL error code for duplicate entry
            echo '<p class="error_msg">Duplicate Member ID! Please choose a different Member ID.</p>';
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
