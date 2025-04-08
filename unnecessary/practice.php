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
//$query = "SELECT * FROM members";
//$result = mysqli_query($connection, $query);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
      
        .form_body {
            margin: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
        form {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            
        }
        label {
            display: block;
            margin: 10px;
            font-size: 20px;
        }
        input[type=text] {
            box-shadow: 0 0 2px black;
            padding: 5px;
            font-size: 1em;
            height:100%;
        }
        #search_btn {
            font-size:20px;
            color:rgb(32, 32, 35);
            background: rgb(149, 198, 205);
            width: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            border:none;
            padding: 4px;
            margin: 0px 5px;
            height:100%;
        }
        #search_btn input[type="submit"] {
            font-size:18px;
            color:rgb(32, 32, 35);
            background: transparent;
            border: none;
            outline: none;
            margin-left: 5px;
        }
        #search_btn:hover {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form_body">
        <form id="search" action="practice.php" method="post">
            <label for="member_search" >Member ID</label>
            <input type="text" name="member_search" id="member_search" required>
            <div id="search_btn">
                <input type="submit" value="Search"><i class='bx bx-search'></i>
            </div>
        </form>
    </div>
</body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $memberID=$_POST['member_search'];
    $memberID = mysqli_real_escape_string($connection, $memberID); // Sanitize input
    $query = "SELECT * FROM members WHERE memberID = '$memberID'";
    $result = mysqli_query($connection, $query); 
    if (!$result) {
        die("member ID is incorrect");
    }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       
        body{
            margin:10px;
            padding:5px;
        }
        table{
            display:flex;
            justify-content:center;
            margin-top:5px;
            margin-bottom:30px;
            border-collapse: collapse;
        }
        th,td{
            padding:10px;
            border:3px solid black;
        }
        th{
            font-size: 1em;
            background-color: azure;
        }
        td{
            background-color: blanchedalmond;
        }
        #due
        {
            color:rgb(232, 68, 68);
        }
        .center{
            text-align:center;
        }
        .success_msg
        {
            text-align:center;
            color:green;
            font-size:20px;
        }
        .error_msg
        {
            text-align:center;
            color:red;
            font-size:20px;
        }
        
        
    </style>
</head>
<body>
<?php 
if ( isset($result) && $result) {
// Check if a row is returned
$member = mysqli_fetch_assoc($result) ;
if(!$member)
{
    echo '<p class="error_msg">incorrect member ID </p>';
    exit;
}
$query = "SELECT transactions.*, books.bookID, books.title
              FROM transactions
              JOIN books ON transactions.BookID = books.BookID
              WHERE transactions.memberID = '$memberID' AND transactions.is_returned = 0;";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("sql error!");
    }

    $booksData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $booksData[] = $row;
    }
}
?>
    <div style="<?php if (!empty($_POST['member_search']) && isset($result) && $result) echo 'display: block;'; else echo 'display: none;'; ?>">
                <h1 class="center">Member Information</h1>
                <table>
                    <tr>
                            <th>Member ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                    </tr>
                    <tr>
                        <td><?=$member['memberID']?></td>
                        <td><?=$member['FirstName']?></td>
                        <td><?=$member['LastName']?></td>
                        <td><?=$member['Email']?></td>
                        <td><?=$member['Phone_no']?></td>
                        <td><?=$member['Address']?></td>
                    </tr>
                </table>
                <h1 class="center">Books currently borrowed</h1>
                <table>
                    <tr>
                            <th>Book ID</th>
                            <th>Book's Title</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>fine</th>
                    </tr>
                    <?php
                        if (isset($booksData)) {
                            foreach ($booksData as $book) {
                                $dueDate = strtotime($book['DueDate']);
                                $currentDate = strtotime(date('Y-m-d'));

                                echo "<tr>";
                                echo "<td>{$book['bookID']}</td>";
                                echo "<td>{$book['title']}</td>";
                                echo "<td>{$book['issueDate']}</td>";
                                echo "<td>{$book['DueDate']}</td>";
                                echo "<td>" . ($dueDate < $currentDate ? 'Fine' : '') . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                 
                </table>
                <li>
                </li>
    </div>   
</body>
</html>
