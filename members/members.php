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

// Create a new connection instance
$conn = new Connection();
$conn->setConnection();
$connection = $conn->getConnection();

// Fetch data from the members table
$query = "SELECT * FROM members";
$result = mysqli_query($connection, $query);

// Store the fetched data in an array
$membersData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $membersData[] = $row;
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - All Members</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .error_msg {
            text-align: center;
            color: red;
            font-size: 20px;
        }

        .success_msg {
            text-align: center;
            color: green;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Members</h2>
        <table>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
            <?php foreach ($membersData as $member): ?>
                <tr>
                    <td><?= $member['memberID'] ?></td>
                    <td><?= $member['FirstName'] ?></td>
                    <td><?= $member['LastName'] ?></td>
                    <td><?= $member['Email'] ?></td>
                    <td><?= $member['Phone_no'] ?></td>
                    <td><?= $member['Address'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
