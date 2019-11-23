<?php
if (isset($_POST["return-user"])) {
    require 'dbh.inc.php';
    $id = $_POST['id'];
    $uid = $_POST['uid'];
    $due = $_POST['due'];
    $textId = $_POST['textId'];

    $date = date('Y-m-d H:i:s');
    $datetime1 = strtotime(date('Y-m-d', strtotime($due)));
    $datetime2 = strtotime(date('Y-m-d', strtotime($date)));

    $secs = $datetime2 - $datetime1;
    $days = $secs / 86400;

    if ($days < 0) {
        $days = 0;
    }

    $qry0 = "UPDATE user SET fine = fine + 3 * $days, no_of_books = no_of_books - 1 WHERE user_id = $uid ";
    $retval0 = mysqli_query($conn, $qry0);
    if (!$retval0) {
        die('FAILED\n: ' . mysqli_error($conn));
        exit();
    }
    $qry = "UPDATE issue SET return_date = CURRENT_TIMESTAMP WHERE issue_id = $id ";
    $qry2 = "UPDATE text SET book_state = 'free' WHERE text_id = $textId ";
    $retval = mysqli_query($conn, $qry);
    $retval2 = mysqli_query($conn, $qry2);
    if (!$retval || !$retval2) {
        die('FAILED\n: ' . mysqli_error($conn));
    } else {
        header("Location: ../profile.php?success=issuesuccess&uid=" . $uid);
    }
    mysqli_close($conn);
    exit();
} else {
    header("Location: ../profile.php");
    exit();
}
