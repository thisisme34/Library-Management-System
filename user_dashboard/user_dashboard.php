<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("location: ../login/login_server.php");
    exit();
}
include('../header/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body
        {
            overflow-x:hidden;
            margin:0;
        }
        
    </style>
</head>
<body>
<div id="bottom_img">
<img src="../images/library_img.png" alt="Book Image" >
</div>
</body>
</html>
