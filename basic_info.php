<?php

include('connection.php');

$totalBooks = null;
$totalMembers = null;

// Create a new connection instance
$conn = new Connection();

$conn->setConnection();
$connection = $conn->getConnection();


// Fetch the total number of books
$booksQuery = "SELECT COUNT(*) as total_books FROM books";
$booksResult = mysqli_query($connection, $booksQuery);

if ($booksResult) {
    $booksData = mysqli_fetch_assoc($booksResult);
    $totalBooks = $booksData['total_books'];
} else {
    die("Error fetching total books: " . mysqli_error($connection));
}

// Fetch the total number of members
$membersQuery = "SELECT COUNT(*) as total_members FROM members";
$membersResult = mysqli_query($connection, $membersQuery);

if ($membersResult) {
    $membersData = mysqli_fetch_assoc($membersResult);
    $totalMembers = $membersData['total_members'];
} else {
    die("Error fetching total members: " . mysqli_error($connection));
}

// Close the database connection
mysqli_close($connection);

// Now you have $totalBooks and $totalMembers containing the respective counts
?>
