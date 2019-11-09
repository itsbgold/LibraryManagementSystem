<?php
include_once "includes/dbh.inc.php";
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
                <li>
                    <a href="login.php">Login</a></li>
                <li><a href="#">Search Books</a></li>
                <li><a href="#">Add Books</a></li>
                <li>
                    <a href="register.php">Add a member</a>
                </li>
            </ul>
        </nav>
        <div>
            <form action="includes/logout.inc.php" method="post">
                <button type="submit" name="logout-submit">LogOut</button>
            </form>
        </div>
    </header>