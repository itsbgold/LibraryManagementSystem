<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["issue-user"])) {
    $textId = $_POST["textId"];
    $userId = $_POST["userId"];
    require 'dbh.inc.php';
    $qry = "INSERT INTO issue ( user_id, text_id, start_date, due_date) VALUES
                (?, ?, CURRENT_TIMESTAMP, DATE_ADD(NOW(), INTERVAL 15 DAY));";
    $qry2 = "UPDATE text SET book_state = 'Issued' WHERE text_id = $textId ";
    $qry3 = "UPDATE user SET no_of_books = no_of_books + 1 WHERE user_id = $userId ";
    $qry4 = "DELETE from reservation WHERE user_id = $userId AND text_id = $textId ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $qry)) {
        header("Location: ../addIssues.php?error=sqlerror&user_id=" . $userId . "&text_id=" . $textId);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $userId, $textId);
        mysqli_stmt_execute($stmt);
        mysqli_query($conn, $qry2);
        mysqli_query($conn, $qry3);
        mysqli_query($conn, $qry4);
        mysqli_close($conn);
        header("Location: ../addIssues.php?success=membersuccess&user_id=" . $userId . "&text_id=" . $textId . "&search-issue-submit=");
        exit();
    }
} else {
    header("Location: ../addIssues.php");
    exit();
}
