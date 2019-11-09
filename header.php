<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Home</a></li>
                <li><a href="#">Search Books</a></li>
                <li><a href="#">Add Books</a></li>
                <?php
                if (isset($_SESSION["user_id"])) {
                    echo '<li>
                    <a href="register.php">Add a member</a>
                </li>
                <form action="includes/logout.inc.php" method="post">
                <button type="submit" name="logout-submit">LogOut</button>
            </form>
            ';
                } else {
                    echo "<li>
                    <a href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>