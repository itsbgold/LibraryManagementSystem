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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/main.css" crossorigin="anonymous">
</head>

<body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php" class="active">Online Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item <? if ($page == "index") { ?>active<? } ?>"><a class="nav-link" href="index.php">Search Books</a></li>
                <?php
                if (isset($_SESSION["user_id"])) {
                    if ($_SESSION["role"] == "admin") { ?>
                        <li class="nav-item <? if ($page == "addbooks") { ?>active<? } ?>"><a class="nav-link" href="addbooks.php">Add Books</a></li>
                        <li class="nav-item <? if ($page == "searchmember") { ?>active<? } ?>"><a class="nav-link" href="searchmember.php">Search members</a></li>
                        <li class="nav-item <? if ($page == "register") { ?>active<? } ?>"><a class="nav-link" href="register.php">Add a member</a></li>
                <? }
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (isset($_SESSION["user_id"])) {
                    ?><li class="nav-item <? if ($page == "profile") { ?>active<? } ?>"><a class="nav-link" href="profile.php">My Profile</a></li>
                    <li><a class="nav-link" href="includes/logout.inc.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
                <? } else { ?>
                    <li class="nav-item <? if ($page == "login") { ?>active<? } ?>"><a class="nav-link" href="login.php"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
                <? }  ?>
            </ul>
        </div>
    </nav>
    <!--/.Navbar -->
    <main class="container">
        <div class="jumbotron text-center">
            <h2>Welcome to the Online Library Manage System</h2>
        </div>
        <br>