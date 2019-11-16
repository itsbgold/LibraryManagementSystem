<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library</title><!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Home</a></li>
                <li><a href="index.php">Search Books</a></li>
                <?php
                if (isset($_SESSION["user_id"])) {
                    if ($_SESSION["role"] == "admin") {
                        echo '
                        <li><a href="addbooks.php">Add Books</a></li>
                        <li><a href="searchmember.php">Search members</a></li>
                        ';
                    }

                    echo '
                    <form action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logout-submit">LogOut</button>
                    </form>
                    ';
                } else {
                    echo "
                    <li><a href='register.php'>Add a member</a></li>
                    <li><a href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Welcome to Library Manage System</h2>
        <br>