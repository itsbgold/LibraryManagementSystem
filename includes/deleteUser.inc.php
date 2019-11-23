<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        require 'dbh.inc.php';
        if ($_SESSION["user_id"] != $id) {
            $retva = mysqli_query($conn, "DELETE from user WHERE user_id = $id ");
            if (!$retval) {
                die('Failed\n: ' . mysqli_error($conn));
                exit();
            };
        }
        mysqli_close($conn);
        header("Location: ../searchmember.php");
        exit();
    }
}
