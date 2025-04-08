<?php
// Include the Connection class
include_once('../basic_info.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System </title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 0 1em  1em 1em;
            margin:0;
            overflow-x: hidden;
        }

        nav {
            background-color: #eee;
            padding: 10px;
        }

        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s; /* Add transition for smooth color change */
        }

        nav a:hover {
            color: #ffc107; /* Change the color on hover */
        }

        nav button {
            color: red;
            font-weight: bold;
            font-size: 18px;
            background: none;
            border: none;
            cursor: pointer;
        }
        nav button:hover{
            background:greenyellow;
        }

        .dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
           /* position: absolute;*/
        }

        .dropdown:hover .dropdown-content {
            display: block;
            position:absolute;
            background-color: #c7e4e9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            padding:10px;
            
        }
        .dropdown:hover .dropdown-content a{
            display: block;
            margin:10px;        
        }
        .dropdown:hover .dropdown-content a:hover{
            color:rgb(216, 136, 70);       
        }
        section {
    padding: 20px;
}

#scrolling-message {
    background-color: #ffc107;
    color: #333;
    text-align: center;
    padding: 10px;
    top: 0;
    width: 100%;
    animation: scroll 15s linear infinite
}

@keyframes scroll {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(100%);
    }
}
       
    </style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <header>
    <div id="scrolling-message">Welcome to the Library Management System!</div>
        <h1><i class='bx bxs-leaf' style='color:#fbf9f9'  ></i>Library Management System</h1>
    </header>

    <nav>
        <a href="../user_dashboard/user_dashboard.php">Home Page</a>
        <a href="../issue_book/issue_book.php">Issue Book</a>
        <a href="../add_books/add_books.php">Add Book</a>
        <a href="../new_user/new_user.php">New User</a>
        <a href="../return_books/return_books.php">Return Book</a>

        <div class="dropdown">
            <a href="#">Statistics<i class='bx bx-chevron-down' ></i></a>
            <div class="dropdown-content">
                <a href="../available_books/available_books.php">Available Books</a>
                <a href="../unreturned/unreturned.php">Unreturned Books</a>
                <a href="../transactions/transactions.php">Transaction Details</a>
                <a href="../members/members.php">Registered Members</a>
                <a href="../search/search.php">Search Member Info</a>
            </div>
        </div>

        <button onclick="confirmLogout()" id="logout">Log out</button>
    </nav>

    <section>
        <h2>Library Information</h2>
        <p>Total number of books available in the library: <?php echo $totalBooks; ?></p>
        <p>Total number of registered members: <?php echo $totalMembers; ?></p>
    </section>
    <script>
    // Function to handle the logout confirmation
    function confirmLogout() {
        var confirmation = confirm("Are you sure you want to logout?");
        if (confirmation) {
            // If the user confirms, redirect to logout.php
            window.location.href = '../logout/logout.php';
        }
    }
    </script>

</body>
</html>
