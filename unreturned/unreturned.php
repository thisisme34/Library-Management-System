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

// Fetch data from the transactions table for unreturned books
$query = "SELECT * FROM transactions WHERE is_returned = 0";
$result = mysqli_query($connection, $query);

// Store the fetched data in an array
$unreturnedBooksData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $unreturnedBooksData[] = $row;
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Unreturned Books</title>
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
        <h2>Unreturned Books</h2>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Book ID</th>
                <th>Member ID</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Issue Date</th>
                <!-- Add more columns as needed -->
            </tr>
            <?php foreach ($unreturnedBooksData as $transaction): ?>
                <tr>
                    <td><?= $transaction['transactionID'] ?></td>
                    <td><?= $transaction['BookID'] ?></td>
                    <td><?= $transaction['MemberID'] ?></td>
                    <td><?= $transaction['DueDate'] ?></td>
                    <td><?= $transaction['ReturnDate'] ?></td>
                    <td><?= $transaction['issueDate'] ?></td>
                    <!-- Add more cells as needed -->
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
