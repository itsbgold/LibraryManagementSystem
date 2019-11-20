<?php

$dbServer = "localhost";
$dbUser = "root";
$dbPwd = "";
$dbName = "library";

// DATABASE CREATION
$connect = mysqli_connect($dbServer, $dbUser, $dbPwd);
if (!$connect) {
    die('SERVER CONNECTION FAILED...\n: ' . mysqli_error($connect));
}
$sql    = 'CREATE DATABASE IF NOT EXISTS library';
$retval = mysqli_query($connect, $sql);
if (!$retval) {
    die('DATABASE CREATION FAILED\n: ' . mysqli_error($connect));
};
mysqli_close($connect);



// TABLES CREATION
$conn = mysqli_connect(
    $dbServer,
    $dbUser,
    $dbPwd,
    $dbName
);

// Text books
$sql = "CREATE TABLE IF NOT EXISTS text (
    text_id int(11) NOT NULL AUTO_INCREMENT,
    title varchar(100) NOT NULL,
    book_state varchar(10) NOT NULL DEFAULT 'free',
    isbn varchar(30) NOT NULL,
    type varchar(10) NOT NULL,
    author varchar(256) NOT NULL,
    subject varchar(256) NOT NULL,
    dop date DEFAULT NULL,
    PRIMARY KEY (text_id),
    UNIQUE (isbn)
  )";
$retval = mysqli_query($conn, $sql);
if (!$retval) {
    die('COULD NOT CREATE TABLE\n: ' . mysqli_error($conn));
};

// Users
$sql = "CREATE TABLE IF NOT EXISTS user (
    user_id int(11) NOT NULL AUTO_INCREMENT,
    firstname varchar(30) NOT NULL,
    lastname varchar(30) NOT NULL,
    email varchar(30) NOT NULL,
    phone varchar(15) NOT NULL,
    address varchar(256) NOT NULL,
    fine int(11) NOT NULL DEFAULT 0,
    password varchar(256) NOT NULL,
    role varchar(6) NOT NULL,
    no_of_books int(11) NOT NULL DEFAULT 0,
    gender varchar(6) NOT NULL,
    PRIMARY KEY(user_id),
    UNIQUE (email)
  )";
$retval = mysqli_query($conn, $sql);
if (!$retval) {
    die('COULD NOT CREATE TABLE\n: ' . mysqli_error($conn));
};

// Reservations
$sql = "CREATE TABLE IF NOT EXISTS reservation (
    resv_id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11),
    text_id int(11),
    time_of_resv DATETIME NOT NULL DEFAULT(CURRENT_TIMESTAMP),
    PRIMARY KEY(resv_id),
    FOREIGN KEY (text_id) REFERENCES text(text_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
  )";
$retval = mysqli_query($conn, $sql);
if (!$retval) {
    die('COULD NOT CREATE TABLE\n: ' . mysqli_error($conn));
};

// Issues
$sql = "CREATE TABLE IF NOT EXISTS issue (
    issue_id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11),
    text_id int(11),
    start_date datetime DEFAULT (CURRENT_TIMESTAMP),
    due_date datetime DEFAULT NULL,
    return_date datetime DEFAULT NULL,
    reissue_date_1 datetime DEFAULT NULL,
    reissue_date_2 datetime DEFAULT NULL,
    reissue_no int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY(issue_id),
    FOREIGN KEY (text_id) REFERENCES text(text_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
  )";
$retval = mysqli_query($conn, $sql);
if (!$retval) {
    die('COULD NOT CREATE TABLE\n: ' . mysqli_error($conn));
};
