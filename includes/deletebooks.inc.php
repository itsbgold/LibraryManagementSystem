<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        require 'dbh.inc.php';
        $retval = mysqli_query($conn, "DELETE from text WHERE text_id='$id'");
        if (!$retval) {
            die('Failed\n: ' . mysqli_error($conn));
            exit();
        };
        mysqli_close($conn);
        header("Location: ../index.php");
        exit();
    }
}
