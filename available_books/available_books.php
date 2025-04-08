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

// Check if the form is submitted for deleting a book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteBook'])) {
    $bookIdToDelete = $_POST['deleteBook'];

    // Display a confirmation message
    echo '<script>
            var confirmDelete = confirm("Are you sure you want to delete this book?");
            if(confirmDelete) {
                // If the user confirms, perform deletion operation
                document.getElementById("deleteBookForm_' . $bookIdToDelete . '").submit();
            }
        </script>';
}


// Fetch data from the books table
$query = "SELECT * FROM books";
$result = mysqli_query($connection, $query);

// Store the fetched data in an array
$booksData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booksData[] = $row;
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - All Books</title>
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

        button {
            cursor: pointer;
        }
        .error_msg
        {
            text-align:center;
            color:red;
            font-size:20px;
        }
        .success_msg
        {
            text-align:center;
            color:green;
            font-size:20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Books</h2>
        <table>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Publisher Name</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($booksData as $book): ?>
                <tr>
                    <td><?= $book['bookID'] ?></td>
                    <td><?= $book['title'] ?></td>
                    <td><?= $book['author'] ?></td>
                    <td><?= $book['price'] ?></td>
                    <td><?= $book['publisher_name'] ?></td>
                    <td>
                        <form method="post" style="margin: 0;">
                            <input type="hidden" name="deleteBook" value="<?= $book['bookID'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function editBook(bookId) {
            // Add logic to handle editing a book
            console.log(`Editing book with ID: ${bookId}`);
        }
    </script>
</body>
</html>
