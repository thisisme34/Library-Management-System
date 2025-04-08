<?php
session_start();
include_once('../connection.php');
include_once('login.html');
// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION['username'])) {
    header("location: ../user_dashboard/user_dashboard.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['login-username'];
    $password = $_POST['login-password'];

    if (validateLogin($username, $password)) {
        $_SESSION['username'] = $username;
        header("location: ../user_dashboard/user_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password";
        echo '<script>alert("' . $error_message . '");</script>';
    }
}

function validateLogin($username, $password)
{
    $conn = new Connection();
    $conn->setConnection();
    $connection = $conn->getConnection();

    $username = mysqli_real_escape_string($connection, $username); // Sanitize input

    // Fetch rows where username and password match
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Check if a row is returned
        if ($row = mysqli_fetch_assoc($result)) {
            mysqli_close($connection); // Close the database connection
            return true;
        }
    }

    mysqli_close($connection); // Close the database connection
    return false;
}

?>
